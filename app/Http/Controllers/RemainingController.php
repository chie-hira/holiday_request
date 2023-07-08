<?php

namespace App\Http\Controllers;

use App\Exports\RemainingExport;
use App\Http\Requests\StoreRemainingRequest;
use App\Http\Requests\UpdateRemainingRequest;
use App\Models\User;
use App\Models\ArchiveRemaining;
use App\Models\Remaining;
use App\Models\ReportCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
// BUG:残日数更新
// 取得推進日に扱い
// 休業、有給取消の項目追加
// TODO:休業日に申請できないようにする
// 金曜日15::00まで申請できないように制御
class RemainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $approvals = Auth::user()->approvals->where('approval_id', 1);

        # 工場単位で一覧作成
        $users = new Collection();
        foreach ($approvals as $approval) {
            $extractions = User::with(['reports', 'remainings'])
                ->where('factory_id', $approval->factory_id)
                ->get();

            $extractions->each(function ($extraction) use ($users) {
                $users->add($extraction);
            });
        }

        $report_categories = ReportCategory::all();

        return view('remainings.index')->with(compact('users', 'report_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRemainingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRemainingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Remaining  $remaining
     * @return \Illuminate\Http\Response
     */
    public function show(Remaining $remaining)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Remaining  $remaining
     * @return \Illuminate\Http\Response
     */
    public function edit(Remaining $remaining)
    {
        return view('remainings.edit')->with(compact('remaining'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRemainingRequest  $request
     * @param  \App\Models\Limit  $limit
     * @return \Illuminate\Http\Response
     */
    public function update(
        UpdateRemainingRequest $request,
        Remaining $remaining
    ) {
        $remaining_days = $request->remaining_days;
        $remaining_hours = $request->remaining_hours;

        $remaining->remaining = $remaining_days * 1 + $remaining_hours * 0.125;

        try {
            $remaining->save();
            return redirect()
                ->route('remainings.index')
                ->with('notice', '取得可能日数を更新しました');
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Remaining  $remaining
     * @return \Illuminate\Http\Response
     */
    public function destroy(Remaining $remaining)
    {
        //
    }

    public function myIndex()
    {
        $my_remainings = Auth::user()->remainings;

        /** 最後の弔事届出から14日で弔事の残日数をリセット */
        # 弔事の届出から14日で自動的にリセット
        # 14日以内に同分類に弔事が発生した場合は、管理者が手動で更新
        $mourning_reports = Auth::user()
            ->reports->whereIn('report_id', [4, 5, 6]);
        if ($mourning_reports->isNotEmpty()) {
            $now = new Carbon(Carbon::now());
            $last_mourning_date = new Carbon($mourning_reports->last()->report_date); # 説明変数
            
            if ($now->diffInDays($last_mourning_date) >= 14) {
                $report_ids = [4, 5, 6];
                foreach ($report_ids as $report_id) {
                    self::resetRemaining($report_id);
                }
            }
        }

        return view('remainings.my_index')->with(compact('my_remainings'));
    }

    /** 残日数リセット関数 */
    public function resetRemaining($report_id)
    {
        $mourning_remaining = Auth::user()->remainings
                            ->where('report_id', $report_id)->first();
        $mourning_remaining->remaining = ReportCategory::find($report_id)->max_days;
        
        return $mourning_remaining->save();
    }

    public function addRemainings(Request $request)
    {
        $request->validate([
            'update_date' => 'required',
        ]);

        /** 更新前データの保存 */
        $excel_name = date('YmdHis') . '_remainings.xlsx';
        Excel::store(new RemainingExport(), 'public/excels/'.$excel_name);
        
        /** remainingsアーカイブ作成 */
        DB::beginTransaction(); # トランザクション開始
        try {
            ArchiveRemaining::query()->delete();
            // ArchiveRemaining::truncate(); # ロールバックできない

            $remainings = Remaining::all();
            $data = [];
            foreach ($remainings as $remaining) {
                $data[] = [
                    'user_id' => $remaining->user_id,
                    'report_id' => $remaining->report_id,
                    'remaining' => $remaining->remaining,
                    'created_at' => $remaining->created_at,
                    'updated_at' => $remaining->updated_at,
                ];
            }
            ArchiveRemaining::insert($data); # インサート
            DB::commit(); # トランザクション成功終了
        } catch (\Exception $e) {
            DB::rollBack(); # トランザクション失敗終了
            return back()
                ->withInput()
                ->withErrors($e->getMessage());
        }

        /** remainings更新 */
        $users = User::with('remainings')->get();
        try {
            foreach ($users as $user) {
                $my_remainings = $user->remainings;
                $remaining_report1 = $my_remainings
                    ->where('report_id', '=', 1)
                    ->first(); # 有給休暇
                $adoption_date_carbon = new Carbon($user->adoption_date); # 採用年月日
                $carbon = new Carbon($request->update_date); # 更新年月日
                $diff = $adoption_date_carbon->diff($carbon);
                $length_of_service = floatval($diff->y . '.' . $diff->m); # 勤続年数
                $remaining_now = $remaining_report1->remaining;

                switch ($length_of_service) {
                    case $length_of_service >= 0.5 && $length_of_service < 1.5:
                        $remaining_report1->remaining = 10 - 3; # 取得推進日3日を除く
                        break;

                    case $length_of_service >= 1.5 && $length_of_service < 2.5:
                        $remaining_add = $remaining_now + 11;
                        if ($remaining_add >= 21) {
                            $remaining_report1->remaining = 21 - 3; # 取得推進日3日を除く
                        } else {
                            $remaining_report1->remaining = $remaining_add - 3; # 取得推進日3日を除く
                        }
                        break;

                    case $length_of_service >= 2.5 && $length_of_service < 3.5:
                        $remaining_add = $remaining_now + 12;
                        if ($remaining_add >= 23) {
                            $remaining_report1->remaining = 23 - 3; # 取得推進日3日を除く
                        } else {
                            $remaining_report1->remaining = $remaining_add - 3; # 取得推進日3日を除く
                        }
                        break;

                    case $length_of_service >= 3.5 && $length_of_service < 4.5:
                        $remaining_add = $remaining_now + 14;
                        if ($remaining_add >= 26) {
                            $remaining_report1->remaining = 26 - 3; # 取得推進日3日を除く
                        } else {
                            $remaining_report1->remaining = $remaining_add - 3; # 取得推進日3日を除く
                        }
                        break;

                    case $length_of_service >= 4.5 && $length_of_service < 5.5:
                        $remaining_add = $remaining_now + 16;
                        if ($remaining_add >= 30) {
                            $remaining_report1->remaining = 30 - 3; # 取得推進日3日を除く
                        } else {
                            $remaining_report1->remaining = $remaining_add - 3; # 取得推進日3日を除く
                        }
                        break;

                    case $length_of_service >= 5.5 && $length_of_service < 6.5:
                        $remaining_add = $remaining_now + 18;
                        if ($remaining_add >= 32) {
                            $remaining_report1->remaining = 32 - 3; # 取得推進日3日を除く
                        } else {
                            $remaining_report1->remaining = $remaining_add - 3; # 取得推進日3日を除く
                        }
                        break;

                    case $length_of_service >= 6.5:
                        $remaining_add = $remaining_now + 20;
                        if ($remaining_add >= 40) {
                            $remaining_report1->remaining = 40 - 3; # 取得推進日3日を除く
                        } else {
                            $remaining_report1->remaining = $remaining_add - 3; # 取得推進日3日を除く
                        }
                        break;
                }
                $remaining_report1->save(); # 有給休暇更新
                $report_ids = [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 16];
                foreach ($report_ids as $report_id) {
                    $remaining_report = $my_remainings
                        ->where('report_id', '=', $report_id)
                        ->first();
                    $remaining_report->remaining = ReportCategory::find(
                        $report_id
                    )->max_days;
                    $remaining_report->save(); # その他休暇更新
                }
            }

            return redirect()
                ->route('remainings.index')
                ->with('notice', '取得可能日数を更新しました');
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->withErrors($th->getMessage());
        }
    }
}
