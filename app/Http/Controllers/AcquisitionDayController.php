<?php

namespace App\Http\Controllers;

use App\Exports\RemainingExport;
use App\Exports\ReportExport;
use App\Exports\ReportFormExport;
use App\Http\Requests\StoreAcquisitionDayRequest;
use App\Http\Requests\UpdateAcquisitionDayRequest;
use App\Imports\AcquisitionDayImport;
use App\Models\User;
use App\Models\AcquisitionDay;
use App\Models\Report;
use App\Models\ReportCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AcquisitionDayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myApprovals = Auth::user()
            ->approvals->where('approval_id', 1)
            ->load('affiliation');

        // 一部管理者の場合
        $users = User::where(function ($query) use ($myApprovals) {
            foreach ($myApprovals as $approval) {
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
            $myApprovals
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

        $reportCategories = ReportCategory::all();

        return view('acquisition_days.index')->with(
            compact('users', 'reportCategories')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AcquisitionDay  $acquisitionDay
     * @return \Illuminate\Http\Response
     */
    public function edit(AcquisitionDay $acquisitionDay)
    {
        return view('acquisition_days.edit')->with(compact('acquisitionDay'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAcquisitionDayRequest  $request
     * @param  \App\Models\AcquisitionDay  $acquisitionDay
     * @return \Illuminate\Http\Response
     */
    public function update(
        UpdateAcquisitionDayRequest $request,
        AcquisitionDay $acquisitionDay
    ) {
        Log::info('Request data:', $request->all());

        // 残日数を管理する休暇の最小単位は半日で設定
        // バリデーション
        $request->validate([
            'remaining_days' => 'multiple_of:0.5',
            'acquisition_days' => 'multiple_of:0.5',
        ]);
        $acquisitionDay->remaining_days = $request->remaining_days;
        $acquisitionDay->acquisition_days = $request->acquisition_days;

        try {
            $acquisitionDay->save();
            return redirect()
                ->route('acquisition_days.index')
                ->with('notice', '休暇日数を更新しました');
        } catch (\Throwable $th) {
            Log::error('Exception caught: ' . $th->getMessage());
            return back()->withErrors('エラーが発生しました');
        }
    }

    public function myIndex()
    {
        $acquisitionDays = Auth::user()->acquisition_days->load(
            'report_category'
        );

        /** 最後の弔事届出から14日で弔事の残日数をリセット */
        # 弔事の届出から14日で自動的にリセット
        # 14日以内に同分類に弔事が発生した場合は、管理者が手動で更新
        $mourningReports = Auth::user()->reports->whereIn('report_id', [
            4,
            5,
            6,
        ]);
        if ($mourningReports->isNotEmpty()) {
            $now = new Carbon(Carbon::now());
            $lastMourningDate = new Carbon(
                $mourningReports->last()->report_date
            ); # 説明変数
            if ($now->diffInDays($lastMourningDate) >= 14) {
                $reportIds = [4, 5, 6];
                foreach ($reportIds as $reportId) {
                    self::resetRemaining($reportId);
                }
            }
        }

        return view('acquisition_days.my_index')->with(
            compact('acquisitionDays')
        );
    }

    public function acquisitionStatus()
    {
        $approvals = Auth::user()
            ->approvals->where('approval_id', '!=', 1)
            ->load('affiliation');
        $users = User::whereHas('affiliation', function ($query) use (
            $approvals
        ) {
            $query->where(function ($query) use ($approvals) {
                foreach ($approvals as $approval) {
                    $query->orWhere(function ($query) use ($approval) {
                        if ($approval->affiliation->department_id == 1) {
                            $query->where(
                                'factory_id',
                                $approval->affiliation->factory_id
                            );
                        } elseif ($approval->affiliation->department_id != 1) {
                            $query
                                ->where(
                                    'factory_id',
                                    $approval->affiliation->factory_id
                                )
                                ->where(
                                    'department_id',
                                    $approval->affiliation->department_id
                                );
                        }
                    });
                }
            });
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
                ->sortBy('affiliation_id')
                ->sortBy('employee');
        }

        $reportCategories = ReportCategory::all();

        return view('acquisition_days.status_index')->with(
            compact('users', 'reportCategories')
        );
    }

    /** 残日数リセット関数 */
    public function resetRemaining($reportId)
    {
        /** 受け取ったreport_idのremainingを初期値で上書きする */
        $resetRemaining = Auth::user()
            ->acquisition_days->where('report_id', $reportId)
            ->first();
        $resetRemaining->remaining_days = ReportCategory::find(
            $reportId
        )->max_days;

        return $resetRemaining->save();
    }

    public function updateForm()
    {
        $files = Storage::files('public/excels');
        $files = array_filter($files, function ($file) {
            // ファイル名に "list" が含まれる場合に true を返す
            return strpos($file, 'list') !== false;
        });

        $filePaths = [];
        foreach ($files as $file) {
            $fileName = pathinfo($file, PATHINFO_FILENAME);
            $filePaths[] = "storage/excels/". $fileName. ".xlsx";
        }

        return view('acquisition_days.update_form')->with(compact('files', 'filePaths'));
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
        // 日数
        $excelName = date('YmdHis') . '_acquisition_days.xlsx';
        Excel::store(new RemainingExport(), 'public/excels/' . $excelName);

        // 申請一覧
        $fileName = date('YmdHis') . '_reports.xlsx';
        Excel::store(new ReportExport(), 'public/excels/' . $fileName);

        // 申請一覧view
        $fileName = date('YmdHi') . '_list.xlsx';
        $reports = Report::where('start_date', '<', $request->update_date)
            ->where('start_date', '<', now()->format('Y-m-d'))
            ->get();
        $view = view('reports.export')->with(compact('reports'));
        Excel::store(new ReportFormExport($view), 'public/excels/' . $fileName);

        /** remainings更新 */
        $users = User::with('acquisition_days')->get();
        try {
            // 申請書削除
            Report::where('start_date', '<', $request->update_date)
                ->where('start_date', '<', now()->format('Y-m-d'))
                ->delete();

            foreach ($users as $user) {
                $acquisitionDays = $user->acquisition_days;

                // 取得日数を初期化
                foreach ($acquisitionDays as $acquisitionDay) {
                    $acquisitionDay->acquisition_days = 0;
                    $acquisitionDay->save();
                }

                $report1Acquisition = $acquisitionDays
                    ->where('report_id', '=', 1)
                    ->first(); # 有給休暇
                $adoptionDateCarbon = new Carbon($user->adoption_date); # 採用年月日
                $carbon = new Carbon($request->update_date); # 更新年月日
                $diff = $adoptionDateCarbon->diff($carbon);
                $lengthOfService = floatval($diff->y . '.' . $diff->m); # 勤続年数
                $remainingNow = $report1Acquisition->remaining_days;

                /** 有給休暇を採用年数で更新 */
                switch ($lengthOfService) {
                    case $lengthOfService >= 0.5 && $lengthOfService < 1.5:
                        $report1Acquisition->remaining_days = 10;
                        break;

                    case $lengthOfService >= 1.5 && $lengthOfService < 2.5:
                        $remainingAdd = $remainingNow + 11;
                        if ($remainingAdd >= 21) {
                            $report1Acquisition->remaining_days = 21;
                        } else {
                            $report1Acquisition->remaining_days =
                                $remainingAdd - 3; # 取得推進日3日を除く
                        }
                        break;

                    case $lengthOfService >= 2.5 && $lengthOfService < 3.5:
                        $remainingAdd = $remainingNow + 12;
                        if ($remainingAdd >= 23) {
                            $report1Acquisition->remaining_days = 23;
                        } else {
                            $report1Acquisition->remaining_days =
                                $remainingAdd - 3; # 取得推進日3日を除く
                        }
                        break;

                    case $lengthOfService >= 3.5 && $lengthOfService < 4.5:
                        $remainingAdd = $remainingNow + 14;
                        if ($remainingAdd >= 26) {
                            $report1Acquisition->remaining_days = 26;
                        } else {
                            $report1Acquisition->remaining_days =
                                $remainingAdd - 3; # 取得推進日3日を除く
                        }
                        break;

                    case $lengthOfService >= 4.5 && $lengthOfService < 5.5:
                        $remainingAdd = $remainingNow + 16;
                        if ($remainingAdd >= 30) {
                            $report1Acquisition->remaining_days = 30;
                        } else {
                            $report1Acquisition->remaining_days =
                                $remainingAdd - 3; # 取得推進日3日を除く
                        }
                        break;

                    case $lengthOfService >= 5.5 && $lengthOfService < 6.5:
                        $remainingAdd = $remainingNow + 18;
                        if ($remainingAdd >= 32) {
                            $report1Acquisition->remaining_days = 32;
                        } else {
                            $report1Acquisition->remaining_days =
                                $remainingAdd - 3; # 取得推進日3日を除く
                        }
                        break;

                    case $lengthOfService >= 6.5:
                        $remainingAdd = $remainingNow + 20;
                        if ($remainingAdd >= 40) {
                            $report1Acquisition->remaining_days = 40;
                        } else {
                            $report1Acquisition->remaining_days =
                                $remainingAdd - 3; # 取得推進日3日を除く
                        }
                        break;
                }
                $report1Acquisition->save(); #_remaining_days 有給休暇更新
                /** 有給休暇以外の休暇の残日数を初期化 */
                $reportCategories = ReportCategory::where(
                    'id',
                    '!=',
                    1
                )->get();
                foreach ($reportCategories as $report) {
                    $acquisitionDay = $acquisitionDays
                        ->where('report_id', $report->id)
                        ->first();
                    $acquisitionDay->remaining_days = ReportCategory::find(
                        $report->id
                    )->max_days;
                    $acquisitionDay->save();
                }
            }

            return redirect()
                ->route('acquisition_days.update_form')
                // ->with(compact('downloadUrl'))
                ->with(
                    'notice',
                    '休暇日数を更新しました。基準日より前の申請書は削除されました。基準日前の申請をダウンロードして保管してください。'
                );
        } catch (\Throwable $th) {
            Log::error('Exception caught: ' . $th->getMessage());
            return back()->withErrors($th->getMessage());
            // return back()->withErrors('エラーが発生しました');
        }
    }

    public function initialImport()
    {
        // 休暇日数インサート
        $users = User::all();
        $reportCategories = ReportCategory::all();
        $chunkSize = 100; // チャンクのサイズ

        foreach ($users as $user) {
            $param = [];

            foreach ($reportCategories as $report) {
                $param[] = [
                    'user_id' => $user->id,
                    'report_id' => $report->id,
                    'remaining_days' => $report->max_days,
                ];
            }

            // パラムをバッチサイズごとに分割してインサート
            $chunks = array_chunk($param, $chunkSize);
            foreach ($chunks as $chunk) {
                DB::table('acquisition_days')->insert($chunk);
            }
        }

        return redirect()
            ->route('import_form')
            ->with('notice', '休暇日数初期設定完了！');
    }

    public function import(Request $request)
    {
        $excelFile = $request->file('excelFile');
        $excelFile->store('excels');
        Excel::import(new AcquisitionDayImport(), $excelFile);

        return redirect()
            ->route('import_form')
            ->with('notice', '休暇日数インポート完了！');
    }
}
