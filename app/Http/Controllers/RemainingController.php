<?php

namespace App\Http\Controllers;

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

class RemainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with(['reports', 'remainings'])->get();
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
    public function update(UpdateRemainingRequest $request, Remaining $remaining)
    {
        $remaining_days = $request->remaining_days;
        $remaining_hours = $request->remaining_hours;

        $remaining->remaining = $remaining_days*1 + $remaining_hours*0.125 ;
        
        try {
            $remaining->save();
            return redirect()
                ->route('remainings.index')
                ->with('notice', '有給休暇の残日数を更新しました');
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

        // 新採用・中途採用
        if (empty($my_remainings->first())) {
            $report_ids = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 16];
            foreach ($report_ids as $report_id) {
                self::newRemaining($report_id);
            }
            $my_remainings = Remaining::all()->where(
                'user_id',
                '==',
                Auth::id()
            );
        }

        return view('remainings.my_index')->with(compact('my_remainings'));
    }

    public function addRemainings(Request $request)
    {
        // 更新前にエクセルファイル出力
        // 更新権限は部長
        $request->validate([
            'update_date' => 'required',
        ]);

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
                        $remaining_report1->remaining = 10;
                        break;

                    case $length_of_service >= 1.5 && $length_of_service < 2.5:
                        $remaining_add = $remaining_now + 11;
                        if ($remaining_add >= 21) {
                            $remaining_report1->remaining = 21;
                        } else {
                            $remaining_report1->remaining = $remaining_add;
                        }
                        break;

                    case $length_of_service >= 2.5 && $length_of_service < 3.5:
                        $remaining_add = $remaining_now + 12;
                        if ($remaining_add >= 23) {
                            $remaining_report1->remaining = 23;
                        } else {
                            $remaining_report1->remaining = $remaining_add;
                        }
                        break;

                    case $length_of_service >= 3.5 && $length_of_service < 4.5:
                        $remaining_add = $remaining_now + 14;
                        if ($remaining_add >= 26) {
                            $remaining_report1->remaining = 26;
                        } else {
                            $remaining_report1->remaining = $remaining_add;
                        }
                        break;

                    case $length_of_service >= 4.5 && $length_of_service < 5.5:
                        $remaining_add = $remaining_now + 16;
                        if ($remaining_add >= 30) {
                            $remaining_report1->remaining = 30;
                        } else {
                            $remaining_report1->remaining = $remaining_add;
                        }
                        break;

                    case $length_of_service >= 5.5 && $length_of_service < 6.5:
                        $remaining_add = $remaining_now + 18;
                        if ($remaining_add >= 32) {
                            $remaining_report1->remaining = 32;
                        } else {
                            $remaining_report1->remaining = $remaining_add;
                        }
                        break;

                    case $length_of_service >= 6.5:
                        $remaining_add = $remaining_now + 20;
                        if ($remaining_add >= 40) {
                            $remaining_report1->remaining = 40;
                        } else {
                            $remaining_report1->remaining = $remaining_add;
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
