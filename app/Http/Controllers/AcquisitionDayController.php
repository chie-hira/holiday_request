<?php

namespace App\Http\Controllers;

use App\Exports\RemainingExport;
use App\Http\Requests\StoreAcquisitionDayRequest;
use App\Http\Requests\UpdateAcquisitionDayRequest;
use App\Imports\AcquisitionDayImport;
use App\Models\User;
use App\Models\AcquisitionDay;
use App\Models\ReportCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
// BUG:残日数更新
// 取得推進日に扱い
// 休業、有給取消の項目追加
// TODO:休業日に申請できないようにする
// 金曜日15::00まで申請できないように制御
class AcquisitionDayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $my_approvals = Auth::user()->approvals->where('approval_id', 1)->load('affiliation');

        // 一部管理者の場合
        $users = User::where(function ($query) use ($my_approvals) {
            foreach ($my_approvals as $approval) {
                if ($approval->affiliation->department_id == 1) {
                    $query->orWhere(function ($query) use ($approval) {
                        $query->whereHas('affiliation', function ($query) use (
                            $approval
                        ) {
                            $query->where(
                                'factory_id',
                                $approval->affiliation->factory_id
                            );
                        });
                    });
                } else {
                    $query->orWhere(function ($query) use ($approval) {
                        $query->whereHas('affiliation', function ($query) use (
                            $approval
                        ) {
                            $query
                                ->where(
                                    'factory_id',
                                    $approval->affiliation->factory_id
                                )
                                ->where(
                                    'department_id',
                                    $approval->affiliation->department_id
                                );
                        });
                    });
                }
            }
        })->get();

        // 全体管理者の場合
        if (
            $my_approvals
                ->where('affiliation_id', 1)
                ->contains('approval_id', 1)
        ) {
            $users = User::all();
        }

        // 重複削除&並べ替え
        $users = $users
            ->unique()
            ->load([
                'affiliation',
                'affiliation.factory',
                'affiliation.department',
                'affiliation.group',
                'acquisition_days',
            ])
            ->sortBy('affiliation_id')
            ->sortBy('employee');

        $report_categories = ReportCategory::all();

        return view('acquisition_days.index')->with(
            compact('users', 'report_categories')
        );
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
     * @param  \App\Http\Requests\StoreAcquisitionDayRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAcquisitionDayRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AcquisitionDay  $acquisition_day
     * @return \Illuminate\Http\Response
     */
    public function show(AcquisitionDay $acquisition_day)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AcquisitionDay  $acquisition_day
     * @return \Illuminate\Http\Response
     */
    public function edit(AcquisitionDay $acquisition_day)
    {
        return view('acquisition_days.edit')->with(compact('acquisition_day'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAcquisitionDayRequest  $request
     * @param  \App\Models\AcquisitionDay  $acquisition_day
     * @return \Illuminate\Http\Response
     */
    public function update(
        UpdateAcquisitionDayRequest $request,
        AcquisitionDay $acquisition_day
    ) {
        Log::info('Request data:', $request->all());
        
        $remaining_days = $request->remaining_days;
        $remaining_hours = $request->remaining_hours;
        $sum_get_days = $request->sum_get_days;
        $sum_get_hours = $request->sum_get_hours;

        $acquisition_day->remaining_days =
            $remaining_days * 1 + $remaining_hours * 0.125;
        $acquisition_day->acquisition_days =
            $sum_get_days * 1 + $sum_get_hours * 0.125;

        try {
            $acquisition_day->save();
            return redirect()
                ->route('acquisition_days.index')
                ->with('notice', '休暇日数を更新しました');
        } catch (\Throwable $th) {
            Log::error('Exception caught: ' . $th->getMessage());
            return back()->withErrors('エラーが発生しました');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AcquisitionDay  $acquisition_day
     * @return \Illuminate\Http\Response
     */
    public function destroy(AcquisitionDay $acquisition_day)
    {
        //
    }

    public function myIndex()
    {
        $acquisition_days = Auth::user()->acquisition_days->load('report_category');

        /** 最後の弔事届出から14日で弔事の残日数をリセット */
        # 弔事の届出から14日で自動的にリセット
        # 14日以内に同分類に弔事が発生した場合は、管理者が手動で更新
        $mourning_reports = Auth::user()->reports->whereIn('report_id', [
            4,
            5,
            6,
        ]);
        if ($mourning_reports->isNotEmpty()) {
            $now = new Carbon(Carbon::now());
            $last_mourning_date = new Carbon(
                $mourning_reports->last()->report_date
            ); # 説明変数
            if ($now->diffInDays($last_mourning_date) >= 14) {
                $report_ids = [4, 5, 6];
                foreach ($report_ids as $report_id) {
                    self::resetRemaining($report_id);
                }
            }
        }

        return view('acquisition_days.my_index')->with(compact('acquisition_days'));
    }

    public function acquisitionStatus()
    {
        $approvals = Auth::user()->approvals->where('approval_id', '!=', 1)->load('affiliation');
        $users = User::where(function ($query) use ($approvals) {
            foreach ($approvals as $approval) {
                if ($approval->affiliation->department_id == 1) {
                    $query->whereHas('affiliation', function ($query) use (
                        $approval
                    ) {
                        $query->where('factory_id', $approval->affiliation->factory_id);
                    });
                } else {
                    $query->whereHas('affiliation', function ($query) use (
                        $approval
                    ) {
                        $query->orWhere(function ($query) use ($approval) {
                            $query
                                ->where('factory_id', $approval->affiliation->factory_id)
                                ->where(
                                    'department_id',
                                    $approval->affiliation->department_id
                                );
                        });
                    });
                }
            }
        })->get();
        if ($approvals->where('affiliation.factory_id', 1)->first()) {
            $users = User::all();
        }

        # 重複削除&並べ替え
        if ($users->first()) {
            $users = $users
                ->unique()
                ->load([
                    'reports',
                    'acquisition_days',
                    'affiliation',
                    'affiliation.factory',
                    'affiliation.department',
                    'affiliation.group',
                ])
                ->sortBy('employee')
                ->sortBy('affiliation_id');
        }
        // dd($users);

        $report_categories = ReportCategory::all();

        return view('acquisition_days.status_index')->with(
            compact('users', 'report_categories')
        );
    }

    /** 残日数リセット関数 */
    public function resetRemaining($report_id)
    {
        /** 受け取ったreport_idのremainingを初期値で上書きする */
        $mourning_acquisition = Auth::user()
            ->acquisition_days->where('report_id', $report_id)
            ->first();
        $mourning_acquisition->remaining_days = ReportCategory::find(
            $report_id
        )->max_days;

        return $mourning_acquisition->save();
    }

    public function addRemainings(Request $request)
    {
        // 二重送信防止
        $request->session()->regenerateToken();
        Log::info('Request data:', $request->all());

        // バリデーション
        $request->validate([
            'update_date' => 'required',
        ]);

        /** 更新前データの保存 */
        $excel_name = date('YmdHis') . '_acquisition_days.xlsx';
        Excel::store(new RemainingExport(), 'public/excels/' . $excel_name);

        /** remainings更新 */
        $users = User::with('acquisition_days')->get();
        try {
            foreach ($users as $user) {
                $acquisition_days = $user->acquisition_days;
                
                // 取得日数を初期化
                foreach ($acquisition_days as $acquisition_day) {
                    $acquisition_day->acquisition_days = 0;
                    $acquisition_day->save();
                }
                
                $report1_acquisition = $acquisition_days
                    ->where('report_id', '=', 1)
                    ->first(); # 有給休暇
                $adoption_date_carbon = new Carbon($user->adoption_date); # 採用年月日
                $carbon = new Carbon($request->update_date); # 更新年月日
                $diff = $adoption_date_carbon->diff($carbon);
                $length_of_service = floatval($diff->y . '.' . $diff->m); # 勤続年数
                $remaining_now = $report1_acquisition->remaining_days;

                /** 有給休暇を採用年数で更新 */
                switch ($length_of_service) {
                    case $length_of_service >= 0.5 && $length_of_service < 1.5:
                        $report1_acquisition->remaining_days = 10 - 3; # 取得推進日3日を除く
                        break;

                    case $length_of_service >= 1.5 && $length_of_service < 2.5:
                        $remaining_add = $remaining_now + 11;
                        if ($remaining_add >= 21) {
                            $report1_acquisition->remaining_days = 21 - 3; # 取得推進日3日を除く
                        } else {
                            $report1_acquisition->remaining_days =
                                $remaining_add - 3; # 取得推進日3日を除く
                        }
                        break;

                    case $length_of_service >= 2.5 && $length_of_service < 3.5:
                        $remaining_add = $remaining_now + 12;
                        if ($remaining_add >= 23) {
                            $report1_acquisition->remaining_days = 23 - 3; # 取得推進日3日を除く
                        } else {
                            $report1_acquisition->remaining_days =
                                $remaining_add - 3; # 取得推進日3日を除く
                        }
                        break;

                    case $length_of_service >= 3.5 && $length_of_service < 4.5:
                        $remaining_add = $remaining_now + 14;
                        if ($remaining_add >= 26) {
                            $report1_acquisition->remaining_days = 26 - 3; # 取得推進日3日を除く
                        } else {
                            $report1_acquisition->remaining_days =
                                $remaining_add - 3; # 取得推進日3日を除く
                        }
                        break;

                    case $length_of_service >= 4.5 && $length_of_service < 5.5:
                        $remaining_add = $remaining_now + 16;
                        if ($remaining_add >= 30) {
                            $report1_acquisition->remaining_days = 30 - 3; # 取得推進日3日を除く
                        } else {
                            $report1_acquisition->remaining_days =
                                $remaining_add - 3; # 取得推進日3日を除く
                        }
                        break;

                    case $length_of_service >= 5.5 && $length_of_service < 6.5:
                        $remaining_add = $remaining_now + 18;
                        if ($remaining_add >= 32) {
                            $report1_acquisition->remaining_days = 32 - 3; # 取得推進日3日を除く
                        } else {
                            $report1_acquisition->remaining_days =
                                $remaining_add - 3; # 取得推進日3日を除く
                        }
                        break;

                    case $length_of_service >= 6.5:
                        $remaining_add = $remaining_now + 20;
                        if ($remaining_add >= 40) {
                            $report1_acquisition->remaining_days = 40 - 3; # 取得推進日3日を除く
                        } else {
                            $report1_acquisition->remaining_days =
                                $remaining_add - 3; # 取得推進日3日を除く
                        }
                        break;
                }
                $report1_acquisition->save(); #_remaining_days 有給休暇更新
                
                /** 有給休暇以外の休暇の残日数を初期化 */
                $report_categories = ReportCategory::where(
                    'id',
                    '!=',
                    1
                )->get();
                foreach ($report_categories as $report) {
                    $acquisition_day = $acquisition_days
                        ->where('report_id', $report->id)
                        ->first();
                    $acquisition_day->remaining_days = ReportCategory::find(
                        $report->id
                    )->max_days;
                    $acquisition_day->save();
                }
            }

            return redirect()
                ->route('acquisition_days.index')
                ->with('notice', '休暇の残日数を更新しました');
        } catch (\Throwable $th) {
            Log::error('Exception caught: ' . $th->getMessage());
            return back()->withErrors('エラーが発生しました');
        }
    }

    public function import(Request $request){
        $excel_file = $request->file('excel_file');
        $excel_file->store('excels');
        Excel::import(new AcquisitionDayImport, $excel_file);

        return redirect()
                ->route('import_form')
                ->with('notice', '休暇日数インポート完了！');
    }
}
