<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\ReasonCategory;
use App\Models\Remaining;
use App\Models\Report;
use App\Models\ReportCategory;
use App\Models\SubReportCategory;
use App\Models\ShiftCategory;
use App\Models\User;
use App\Models\Approval;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;
use Faker\Factory;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::all()
            ->where('user_id', Auth::user()->id)
            ->sortBy('report_date');
        return view('reports.index')->with(compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $report_categories = ReportCategory::all();
        $sub_report_categories = SubReportCategory::all();
        $reasons = ReasonCategory::all();
        $shifts = ShiftCategory::all();
        $my_remainings = Auth::user()->remainings;
        $my_reports = Auth::user()->reports;

        $report_categories = ReportCategory::whereHas('remainings', function (
            $query
        ) {
            $query
                ->where('remaining', '!=', 0)
                ->where('user_id', Auth::user()->id);
        })
            ->orWhere(function ($query) {
                $query
                    ->where('id', 12)
                    ->orWhere('id', 13)
                    ->orWhere('id', 14)
                    ->orWhere('id', 15)
                    ->orWhere('id', 17)
                    ->orWhere('id', 18);
            })
            ->get();

        $birthday = new Carbon(
            Carbon::now()->year . '-' . Auth::user()->birthday
        ); # 誕生日
        if (
            now()->subMonths(3) > $birthday ||
            now()->addMonths(3) < $birthday
        ) {
            $report_categories = $report_categories->where('id', '!=', 2);
        }

        return view('reports.create')->with(
            compact(
                'report_categories',
                'sub_report_categories',
                'reasons',
                'shifts',
                'my_remainings',
                'my_reports'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReportRequest $request)
    {
        // バリデーション
        if (
            $request->report_id == 1 || # 有給
            $request->report_id == 7 || # 特別休暇(看護・対象1名)
            $request->report_id == 8 || # 特別休暇(看護・対象2名)
            $request->report_id == 9 || # 特別休暇(介護・対象1名)
            $request->report_id == 10 # 特別休暇(介護・対象2名)
        ) {
            $request->validate([
                'sub_report_id' => 'required|integer',
            ]);
            if ($request->sub_report_id == 1) {
                # 終日休暇
                $request->validate(
                    [
                        'start_date' =>
                            'required|date|after:today|after_or_equal:report_date',
                        'get_days' => 'required|integer|min:1',
                    ],
                    [
                        'get_days.min' => '取得日数は1日以上です。',
                    ]
                );
            }
            if ($request->sub_report_id == 2) {
                # 連休
                $request->validate(
                    [
                        'start_date' =>
                            'required|date|after:today|after_or_equal:report_date',
                        'end_date' =>
                            'required|date|after_or_equal:start_date|sameMonth:start_date',
                        'get_days' => 'required|integer|min:2',
                    ],
                    [
                        'get_days.min' => '取得日数は2日以上です。',
                    ]
                );
            }
            if ($request->sub_report_id == 3) {
                # 半日休暇
                $request->validate(
                    [
                        'start_date' =>
                            'required|date|after:today|after_or_equal:report_date',
                        'am_pm' => 'required|integer',
                        'get_days' => ['required', Rule::in(0.5)],
                    ],
                    [
                        'get_days.in' => '半日有休は4時間です。',
                        'am_pm.required' => '午前・午後を選択してください。',
                        'am_pm.integer' => '午前・午後を選択してください。',
                    ]
                );
            }
            if ($request->sub_report_id == 4) {
                # 時間休
                $request->validate(
                    [
                        'start_date' =>
                            'required|date|after:today|after_or_equal:report_date',
                        'start_time' => 'required|date_format:H:i',
                        'end_time' =>
                            'required|date_format:H:i|after:start_time',
                        'get_days' => [
                            'required',
                            Rule::in([
                                0.125,
                                0.25,
                                0.375,
                                0.5,
                                0.625,
                                0.75,
                                0.825,
                            ]),
                        ],
                    ],
                    [
                        'get_days.in' => '時間休は1時間単位です。',
                    ]
                );
            }
        }
        if (
            $request->report_id == 2 || # バースデイ
            $request->report_id == 12 # 欠勤
        ) {
            $request->validate(
                [
                    'start_date' =>
                        'required|date|after:today|after_or_equal:report_date',
                    'get_days' => ['required', Rule::in(1.0)],
                ],
                [
                    'get_days.in' => '1日単位です。',
                ]
            );
        }
        if (
            $request->report_id == 3 || # 特別休暇(慶事)
            $request->report_id == 4 || # 特別休暇(弔事)
            $request->report_id == 5 || # 特別休暇(弔事)
            $request->report_id == 6 || # 特別休暇(弔事)
            $request->report_id == 11 || # 特別休暇(短期育休)
            $request->report_id == 16 || # 介護休業
            $request->report_id == 17 || # 育児休業
            $request->report_id == 18
        ) {
            # パパ育休
            $request->validate(
                [
                    'start_date' => 'required|date|after_or_equal:report_date',
                    'end_date' => 'required|date|after_or_equal:start_date',
                    'get_days' => 'required|integer|min:1',
                ],
                [
                    'get_days.min' => '取得日数は1日以上です。',
                ]
            );
        }
        if (
            $request->report_id == 13 || # 遅刻
            $request->report_id == 14
        ) {
            # 早退
            $request->validate(
                [
                    'start_time' => 'required|date_format:H:i',
                    'end_time' => 'required|date_format:H:i|after:start_time',
                    'get_days' => [
                        'required',
                        Rule::in([
                            0.02083,
                            0.04167,
                            0.0625,
                            0.08333,
                            0.10417,
                            0.125,
                            0.14583,
                            0.16667,
                            0.1875,
                            0.20833,
                            0.22917,
                            0.25,
                            0.27083,
                            0.29167,
                            0.3125,
                            0.33333,
                            0.35417,
                            0.375,
                            0.39583,
                            0.41667,
                            0.4375,
                            0.45833,
                            0.47917,
                            0.5,
                            0.52083,
                            0.54167,
                            0.5625,
                            0.58333,
                            0.60417,
                            0.625,
                            0.64583,
                            0.66667,
                            0.6875,
                            0.70833,
                            0.72917,
                            0.75,
                            0.77083,
                            0.79167,
                            0.8125,
                            0.83333,
                            0.85417,
                            0.825,
                            0.89583,
                            0.91667,
                            0.9375,
                            0.95833,
                            0.97917,
                        ]),
                    ],
                ],
                [
                    'get_days.in' => '遅刻・早退は10分単位です。',
                ]
            );
        }
        if ($request->report_id == 15) {
            # 外出
            $request->validate(
                [
                    'start_time' => 'required|date_format:H:i',
                    'end_time' => 'required|date_format:H:i|after:start_time',
                    'get_days' => [
                        'required',
                        Rule::in([
                            0.0625,
                            0.125,
                            0.1875,
                            0.25,
                            0.3125,
                            0.375,
                            0.4375,
                            0.5,
                            0.5625,
                            0.625,
                            0.6875,
                            0.75,
                            0.8125,
                            0.825,
                            0.9375,
                        ]),
                    ],
                ],
                [
                    'get_days.in' => '外出は30分単位です。',
                ]
            );
        }
        if ($request->reason_id == 9) {
            # 理由:その他
            $request->validate(
                [
                    'reason_detail' => 'required|max:200',
                ],
                [
                    'reason_detail.required' => '理由は必須です。',
                ]
            );
        }

        $remaining = Remaining::where('user_id', '=', Auth::user()->id)
            ->where('report_id', $request->report_id)
            ->first('remaining');
        if (!empty($remaining->remaining)) {
            $result = $remaining->remaining - $request->get_days; // 説明変数

            if ($result < 0) {
                throw ValidationException::withMessages([
                    'get_days' => ['取得上限を超えています'],
                ]);
            }
        }

        # reportsレコード作成
        $report = new Report();
        $report->fill($request->all());

        /** 自分の届出を自分で承認する場合 */
        # 工場長
        if (
            !empty(
                Auth::user()
                    ->approvals->where('approval_id', 2)
                    ->first()
            )
        ) {
            $report->approval1 = 1;
            $report->approval3 = 1;
            $report->approved = 1;

            DB::beginTransaction(); # トランザクション開始
            try {
                $report->save();
                $remaining = Remaining::where('user_id', $report->user_id)
                    ->where('report_id', $report->report_id)
                    ->first();
                if (!empty($remaining)) {
                    $new_remaining = $remaining->remaining - $report->get_days;
                    $remaining->remaining = $new_remaining;
                    $remaining->save(); # 残日数を保存
                }
                DB::commit(); # トランザクション成功終了
                return redirect()
                    ->route('reports.show', $report)
                    ->with('msg', '承認しました');
            } catch (\Exception $e) {
                DB::rollBack(); # トランザクション失敗終了
                return back()
                    ->withInput()
                    ->withErrors($e->getMessage());
            }
        }
        # GL
        if (
            !empty(
                Auth::user()
                    ->approvals->where('approval_id', 3)
                    ->first()
            )
        ) {
            $report->approval2 = 1;
        }

        try {
            $report->save();
            $user = $report->user()->first();
            // $user->approved($report); # 届出作成者に通知

            // $reportのユーザーを承認するユーザー
            // FIXME:工場長の場合を追加
            $approver = User::whereHas('approvals', function ($query) use (
                $report
            ) {
                $query
                    ->where('approval_id', 2)
                    ->where('factory_id', $report->user->factory_id);
            })->get();
            if ($approver->contains('department_id', 1)) {
                $general_approver = User::whereHas('approvals', function (
                    $query
                ) use ($report) {
                    $query
                        ->where('approval_id', 2)
                        ->where('factory_id', $report->user->factory_id);
                })->first();
                if ($general_approver) {
                    $general_approver->storeReport($report);
                }
            } else {
                $general_approver = User::whereHas('approvals', function (
                    $query
                ) use ($report) {
                    $query
                        ->where('approval_id', 2)
                        ->where('factory_id', $report->user->factory_id)
                        ->where('department_id', $report->user->department_id);
                })->first();
                if ($general_approver) {
                    $general_approver->storeReport($report);
                }
            }

            $manager_approver = User::whereHas('approvals', function (
                $query
            ) use ($report) {
                $query
                    ->where('approval_id', 3)
                    ->where('factory_id', $report->user->factory_id)
                    ->where('department_id', $report->user->department_id);
            })->first();
            if ($manager_approver) {
                $manager_approver->storeReport($report);
            }

            $group_approvers = User::whereHas('approvals', function (
                $query
            ) use ($report) {
                $query
                    ->where('approval_id', 4)
                    ->where('factory_id', $report->user->factory_id)
                    ->where('department_id', $report->user->department_id)
                    ->where('group_id', $report->user->group_id);
            })->get();
            if ($group_approvers) {
                foreach ($group_approvers as $group_approver) {
                    $group_approver->storeReport($report);
                }
            }

            return redirect(route('reports.show', $report))->with(
                'notice',
                '届出を提出しました'
            );
        } catch (\Throwable $th) {
            return back()
                ->withErrors($th->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        return view('reports.show')->with(compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        $report_categories = ReportCategory::all();
        $sub_report_categories = SubReportCategory::all();
        $reasons = ReasonCategory::all();
        $my_remainings = Remaining::all()->where('user_id', Auth::id());

        return view('reports.edit')->with(
            compact(
                'report',
                'report_categories',
                'sub_report_categories',
                'reasons',
                'my_remainings'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReportRequest  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReportRequest $request, Report $report)
    {
        if (
            $request->report_id == 1 || # 有給
            $request->report_id == 7 || # 特別休暇(看護・対象1名)
            $request->report_id == 8 || # 特別休暇(看護・対象2名)
            $request->report_id == 9 || # 特別休暇(介護・対象1名)
            $request->report_id == 10
        ) {
            # 特別休暇(介護・対象2名)
            $request->validate([
                'sub_report_id' => 'required|integer',
            ]);
            if ($request->sub_report_id == 1) {
                # 終日休暇
                // dd($request);
                $request->validate(
                    [
                        'start_date' =>
                            'required|date|after_or_equal:report_date',
                        'end_date' => 'required|date|after_or_equal:start_date',
                        'get_days' => 'required|integer|min:1',
                    ],
                    [
                        'get_days.min' =>
                            '取得日数は1日以上で取得可能です。日数算出ボタンを押してください。',
                    ]
                );
            }
            if ($request->sub_report_id == 2) {
                # 半日休暇
                $request->validate(
                    [
                        'start_date' =>
                            'required|date|after_or_equal:report_date',
                        'am_pm' => 'required|integer',
                        'get_days' => ['required', Rule::in(0.5)],
                    ],
                    [
                        'get_days.in' => '日付算出ボタンを押してください。',
                        'am_pm.required' => '午前・午後を選択してください。',
                        'am_pm.integer' => '午前・午後を選択してください。',
                    ]
                );
            }
            if ($request->sub_report_id == 3) {
                # 時間休
                $request->validate(
                    [
                        'start_time' => 'required|date_format:H:i',
                        'end_time' =>
                            'required|date_format:H:i|after:start_time',
                        'get_days' => [
                            'required',
                            Rule::in([
                                0.125,
                                0.25,
                                0.375,
                                0.5,
                                0.625,
                                0.75,
                                0.825,
                            ]),
                        ],
                    ],
                    [
                        'get_days.in' =>
                            '時間休は1時間単位で取得可能です。日数算出ボタンを押してください。',
                    ]
                );
            }
        }
        if (
            $request->report_id == 2 || # バースデイ
            $request->report_id == 12
        ) {
            # 欠勤
            $request->validate(
                [
                    'start_date' => 'required|date|after_or_equal:report_date',
                    'get_days' => ['required', Rule::in(1.0)],
                ],
                [
                    'get_days.in' => '日付算出ボタンを押してください。',
                ]
            );
            $report->sub_report_id = null;
        }
        if (
            $request->report_id == 3 || # 特別休暇(慶事)
            $request->report_id == 4 || # 特別休暇(弔事)
            $request->report_id == 5 || # 特別休暇(弔事)
            $request->report_id == 6 || # 特別休暇(弔事)
            $request->report_id == 11 || # 特別休暇(短期育休)
            $request->report_id == 16 || # 介護休業
            $request->report_id == 17 || # 育児休業
            $request->report_id == 18
        ) {
            # パパ育休
            $request->validate(
                [
                    'start_date' => 'required|date|after_or_equal:report_date',
                    'end_date' => 'required|date|after_or_equal:start_date',
                    'get_days' => 'required|integer|min:1',
                ],
                [
                    'get_days.min' =>
                        '取得日数は1日以上で取得可能です。日数算出ボタンを押してください。',
                ]
            );
            $report->sub_report_id = null;
        }
        if (
            $request->report_id == 13 || # 遅刻
            $request->report_id == 14
        ) {
            # 早退
            $request->validate(
                [
                    'start_time' => 'required|date_format:H:i',
                    'end_time' => 'required|date_format:H:i|after:start_time',
                    'get_days' => [
                        'required',
                        Rule::in([
                            0.02083,
                            0.04167,
                            0.0625,
                            0.08333,
                            0.10417,
                            0.125,
                            0.14583,
                            0.16667,
                            0.1875,
                            0.20833,
                            0.22917,
                            0.25,
                            0.27083,
                            0.29167,
                            0.3125,
                            0.33333,
                            0.35417,
                            0.375,
                            0.39583,
                            0.41667,
                            0.4375,
                            0.45833,
                            0.47917,
                            0.5,
                            0.52083,
                            0.54167,
                            0.5625,
                            0.58333,
                            0.60417,
                            0.625,
                            0.64583,
                            0.66667,
                            0.6875,
                            0.70833,
                            0.72917,
                            0.75,
                            0.77083,
                            0.79167,
                            0.8125,
                            0.83333,
                            0.85417,
                            0.825,
                            0.89583,
                            0.91667,
                            0.9375,
                            0.95833,
                            0.97917,
                        ]),
                    ],
                ],
                [
                    'get_days.in' =>
                        '遅刻・早退は10分単位で取得可能です。日付算出ボタンを押してください。',
                ]
            );
            $report->sub_report_id = null;
        }
        if ($request->report_id == 15) {
            # 外出
            $request->validate(
                [
                    'start_time' => 'required|date_format:H:i',
                    'end_time' => 'required|date_format:H:i|after:start_time',
                    'get_days' => [
                        'required',
                        Rule::in([
                            0.0625,
                            0.125,
                            0.1875,
                            0.25,
                            0.3125,
                            0.375,
                            0.4375,
                            0.5,
                            0.5625,
                            0.625,
                            0.6875,
                            0.75,
                            0.8125,
                            0.825,
                            0.9375,
                        ]),
                    ],
                ],
                [
                    'get_days.in' =>
                        '外出は30分単位で取得可能です。日付算出ボタンを押してください。',
                ]
            );
            $report->sub_report_id = null;
        }
        if ($request->reason_id == 8) {
            # 理由:その他
            $request->validate(
                [
                    'reason_detail' => 'required|max:200',
                ],
                [
                    'reason_detail.required' => '理由は必須です。',
                ]
            );
        }

        $remaining = Remaining::where('user_id', Auth::user()->id)
            ->where('report_id', $request->report_id)
            ->first('remaining');
        if (!empty($remaining->remaining)) {
            $result = $remaining->remaining - $request->get_days; // 説明変数

            if ($result < 0) {
                throw ValidationException::withMessages([
                    'get_days' => ['取得上限を超えています'],
                ]);
            }
        }

        # reportsレコード更新&承認リセット
        $report->fill($request->all());
        $report->approval1 = 0;
        $report->approval2 = 0;

        try {
            $report->save();
            return redirect(route('reports.show', $report))->with(
                'notice',
                '届出を更新しました'
            );
        } catch (\Throwable $th) {
            return back()
                ->withErrors($th->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        $report->cancel = 1;
        $report->save();

        # 誰も承認していない場合
        if (
            $report->cancel == 1 &&
            $report->approval1 == 0 &&
            $report->approval2 == 0
        ) {
            try {
                $report->delete();
                return redirect()
                    ->route('reports.index')
                    ->with('notice', '届出を取消しました');
            } catch (\Throwable $th) {
                return back()->withErrors($th->getMessage());
            }
        } else {
            # 承認がある場合
            return redirect()
                ->route('reports.index')
                ->with('notice', '届出の取消を申請しました');
        }
    }

    /** 承認済み届出の取消申請 */
    public function approvedCancel(Report $report)
    {
        $report->cancel = 1; # キャンセルon
        $approvals = Auth::user()->approvals;

        /** 通常の承認取消*/
        # 総務部承認取消
        if (
            $approvals
                ->where('factory_id', $report->user->factory_id)
                ->where('department_id', 7) # 総務部
                ->where('approval_id', 2)
                ->first() &&
            $report->user->department_id == 7
        ) {
            $report->approval1 = 0;
        }

        # 工場長承認取消
        if (
            $approvals
                ->where('factory_id', $report->user->factory_id)
                ->where('department_id', '!=', 7) # 総務部以外
                ->where('approval_id', 2)
                ->first() &&
            $report->user->department_id != 7
        ) {
            $report->approval1 = 0;
        }

        # GL承認取消
        if (
            $approvals
                ->where('factory_id', $report->user->factory_id)
                ->where('department_id', $report->user->department_id)
                ->where('approval_id', 3)
                ->first()
        ) {
            $report->approval2 = 0;
        }

        /** イレギュラーな承認取消*/
        # GLがいない部署の届を承認取消
        if (
            $approvals->contains('approval_id', 2) &&
            $report->user->group->id == 1
        ) {
            $report->approval1 = 0;
            $report->approval2 = 0;

            /** remainingを更新 */
            $remaining = Remaining::all()
                ->where('report_id', $report->report_id)
                ->where('user_id', $report->user_id)
                ->first();
            if (empty($remaining)) {
                # remainingがない場合
                try {
                    $report->delete();
                    return redirect()
                        ->route('reports.approved')
                        ->with('notice', '届出を取消しました');
                } catch (\Throwable $th) {
                    return back()->withErrors($th->getMessage());
                }
            } else {
                # remainingがある場合
                /** 残日数加算&届け取消 */
                $remaining->remaining += $report->get_days;
                DB::beginTransaction(); # トランザクション開始
                try {
                    $remaining->save();
                    $report->delete();

                    DB::commit(); # トランザクション成功終了
                    return redirect()
                        ->route('reports.approved')
                        ->with('notice', '届出を取消しました');
                } catch (\Throwable $th) {
                    DB::rollBack(); # トランザクション失敗終了
                    return back()->withErrors($th->getMessage());
                }
            }
        }

        try {
            $report->save();
            return redirect()
                ->route('reports.index')
                ->with('notice', '取消申請しました');
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }

    # 承認待ちのreports
    public function pendingApproval()
    {
        $approvals = Auth::user()->approvals;
        $reports = new Collection();

        # 閲覧
        if ($approvals->contains('approval_id', 5)) {
            $reader_apps = $approvals->where('approval_id', 5);
            # 工場全体閲覧
            if ($reader_apps->contains('department_id', 1)) {
                foreach ($reader_apps as $approval) {
                    $extractions = Report::whereHas('user', function (
                        $query
                    ) use ($approval) {
                        $query->where('factory_id', $approval->factory_id);
                    })
                        ->where(function ($query) {
                            $query->where('approved', 0);
                        })
                        ->get();
                    $extractions->each(function ($extraction) use ($reports) {
                        $reports->add($extraction);
                    });
                }
            }

            # 課全体閲覧
            if (
                !$reader_apps->contains('department_id', 1) &&
                $reader_apps->contains('group_id', 1)
            ) {
                foreach ($reader_apps as $approval) {
                    $extractions = Report::whereHas('user', function (
                        $query
                    ) use ($approval) {
                        $query
                            ->where('factory_id', $approval->factory_id)
                            ->where('department_id', $approval->department_id);
                    })
                        ->where(function ($query) {
                            $query->where('approved', 0);
                        })
                        ->get();
                    $extractions->each(function ($extraction) use ($reports) {
                        $reports->add($extraction);
                    });
                }
            }

            # グループ閲覧
            if (
                !$reader_apps->contains('department_id', 1) &&
                !$reader_apps->contains('group_id', 1)
            ) {
                foreach ($reader_apps as $approval) {
                    $extractions = Report::whereHas('user', function (
                        $query
                    ) use ($approval) {
                        $query
                            ->where('factory_id', $approval->factory_id)
                            ->where('department_id', $approval->department_id)
                            ->where('group_id', $approval->group_id);
                    })
                        ->where(function ($query) {
                            $query->where('approved', 0);
                        })
                        ->get();
                    $extractions->each(function ($extraction) use ($reports) {
                        $reports->add($extraction);
                    });
                }
            }
        }

        # GL承認
        if ($approvals->contains('approval_id', 4)) {
            $group_apps = $approvals->where('approval_id', 4);
            foreach ($group_apps as $approval) {
                $extractions = Report::whereHas('user', function ($query) use (
                    $approval
                ) {
                    $query
                        ->where('factory_id', $approval->factory_id)
                        ->where('department_id', $approval->department_id)
                        ->where('group_id', $approval->group_id);
                })
                    ->where(function ($query) {
                        $query->where('approved', 0);
                    })
                    ->get();

                $extractions->each(function ($extraction) use ($reports) {
                    $reports->add($extraction);
                });
            }
        }

        # 課長承認
        if ($approvals->contains('approval_id', 3)) {
            $department_apps = $approvals->where('approval_id', 3);
            foreach ($department_apps as $approval) {
                $extractions = Report::whereHas('user', function ($query) use (
                    $approval
                ) {
                    $query
                        ->where('factory_id', $approval->factory_id)
                        ->where('department_id', $approval->department_id);
                })
                    ->where(function ($query) {
                        $query->where('approved', 0);
                    })
                    ->get();

                $extractions->each(function ($extraction) use ($reports) {
                    $reports->add($extraction);
                });
            }
        }

        # 工場長承認:課ごと
        if (
            $approvals
                ->where('approval_id', 2)
                ->where('department_id', '!=', 1) # 課ごと
                ->first()
        ) {
            $department_apps = $approvals
                ->where('approval_id', 2)
                ->where('department_id', '!=', 1);
            foreach ($department_apps as $approval) {
                $extractions = Report::whereHas('user', function ($query) use (
                    $approval
                ) {
                    $query
                        ->where('factory_id', $approval->factory_id)
                        ->where('department_id', $approval->department_id);
                })
                    ->where(function ($query) {
                        $query->where('approved', 0);
                    })
                    ->get();

                $extractions->each(function ($extraction) use ($reports) {
                    $reports->add($extraction);
                });
            }
        }

        # 工場長承認:包括
        if (
            $approvals
                ->where('approval_id', 2)
                ->where('department_id', 1) # 全課
                ->first()
        ) {
            $department_apps = $approvals
                ->where('approval_id', 2)
                ->where('department_id', 1);
            foreach ($department_apps as $approval) {
                $extractions = Report::whereHas('user', function ($query) use (
                    $approval
                ) {
                    $query->where('factory_id', $approval->factory_id);
                })
                    ->where(function ($query) {
                        $query->where('approved', 0);
                    })
                    ->get();

                $extractions->each(function ($extraction) use ($reports) {
                    $reports->add($extraction);
                });
            }
        }

        # 重複削除&並べ替え
        $reports = $reports
            ->unique()
            ->sortBy('report_date')
            ->sortBy('user.factory_id')
            ->sortBy('user.department_id');

        return view('reports.pending_approval')->with(compact('reports'));
    }

    # 承認済みのreports
    public function approved()
    {
        $approvals = Auth::user()->approvals;
        $reports = new Collection();

        # 閲覧
        if ($approvals->contains('approval_id', 5)) {
            $reader_apps = $approvals->where('approval_id', 5);
            # 工場全体閲覧
            if ($reader_apps->contains('department_id', 1)) {
                foreach ($reader_apps as $approval) {
                    $extractions = Report::whereHas('user', function (
                        $query
                    ) use ($approval) {
                        $query->where('factory_id', $approval->factory_id);
                    })
                        ->where(function ($query) {
                            $query->where('approved', 1);
                        })
                        ->get();
                    $extractions->each(function ($extraction) use ($reports) {
                        $reports->add($extraction);
                    });
                }
            }

            # 課全体閲覧
            if (
                !$reader_apps->contains('department_id', 1) &&
                $reader_apps->contains('group_id', 1)
            ) {
                foreach ($reader_apps as $approval) {
                    $extractions = Report::whereHas('user', function (
                        $query
                    ) use ($approval) {
                        $query
                            ->where('factory_id', $approval->factory_id)
                            ->where('department_id', $approval->department_id);
                    })
                        ->where(function ($query) {
                            $query->where('approved', 1);
                        })
                        ->get();
                    $extractions->each(function ($extraction) use ($reports) {
                        $reports->add($extraction);
                    });
                }
            }

            # グループ閲覧
            if (
                !$reader_apps->contains('department_id', 1) &&
                !$reader_apps->contains('group_id', 1)
            ) {
                foreach ($reader_apps as $approval) {
                    $extractions = Report::whereHas('user', function (
                        $query
                    ) use ($approval) {
                        $query
                            ->where('factory_id', $approval->factory_id)
                            ->where('department_id', $approval->department_id)
                            ->where('group_id', $approval->group_id);
                    })
                        ->where(function ($query) {
                            $query->where('approved', 1);
                        })
                        ->get();
                    $extractions->each(function ($extraction) use ($reports) {
                        $reports->add($extraction);
                    });
                }
            }
        }

        # GL承認
        if ($approvals->contains('approval_id', 4)) {
            $group_apps = $approvals->where('approval_id', 4);
            foreach ($group_apps as $approval) {
                $extractions = Report::whereHas('user', function ($query) use (
                    $approval
                ) {
                    $query
                        ->where('factory_id', $approval->factory_id)
                        ->where('department_id', $approval->department_id)
                        ->where('group_id', $approval->group_id);
                })
                    ->where(function ($query) {
                        $query->where('approved', 1);
                    })
                    ->get();

                $extractions->each(function ($extraction) use ($reports) {
                    $reports->add($extraction);
                });
            }
        }

        # 課長承認
        if ($approvals->contains('approval_id', 3)) {
            $department_apps = $approvals->where('approval_id', 3);
            foreach ($department_apps as $approval) {
                $extractions = Report::whereHas('user', function ($query) use (
                    $approval
                ) {
                    $query
                        ->where('factory_id', $approval->factory_id)
                        ->where('department_id', $approval->department_id);
                })
                    ->where(function ($query) {
                        $query->where('approved', 1);
                    })
                    ->get();

                $extractions->each(function ($extraction) use ($reports) {
                    $reports->add($extraction);
                });
            }
        }

        # 工場長承認:課ごと
        if (
            $approvals
                ->where('approval_id', 2)
                ->where('department_id', '!=', 1) # 課ごと
                ->first()
        ) {
            $department_apps = $approvals
                ->where('approval_id', 2)
                ->where('department_id', '!=', 1);
            foreach ($department_apps as $approval) {
                $extractions = Report::whereHas('user', function ($query) use (
                    $approval
                ) {
                    $query
                        ->where('factory_id', $approval->factory_id)
                        ->where('department_id', $approval->department_id);
                })
                    ->where(function ($query) {
                        $query->where('approved', 1);
                    })
                    ->get();

                $extractions->each(function ($extraction) use ($reports) {
                    $reports->add($extraction);
                });
            }
        }

        # 工場長承認:包括
        if (
            $approvals
                ->where('approval_id', 2)
                ->where('department_id', 1) # 全課
                ->first()
        ) {
            $department_apps = $approvals
                ->where('approval_id', 2)
                ->where('department_id', 1);
            foreach ($department_apps as $approval) {
                $extractions = Report::whereHas('user', function ($query) use (
                    $approval
                ) {
                    $query->where('factory_id', $approval->factory_id);
                })
                    ->where(function ($query) {
                        $query->where('approved', 1);
                    })
                    ->get();

                $extractions->each(function ($extraction) use ($reports) {
                    $reports->add($extraction);
                });
            }
        }

        # 重複削除&並べ替え
        $reports = $reports
            ->unique()
            ->sortBy('report_date')
            ->sortBy('user.factory_id')
            ->sortBy('user.department_id');

        return view('reports.approved')->with(compact('reports'));
    }

    public function getAndRemaining()
    {
        $approvals = Auth::user()->approvals;
        $users = '';

        # 工場承認
        if ($approvals->contains('approval_id', 2)) {
            $factory_apps = $approvals->where('approval_id', 2);
            $users = User::with(['reports', 'remainings'])
                ->where(function ($query) use ($factory_apps) {
                    foreach ($factory_apps as $approval) {
                        $query->orWhere('factory_id', $approval->factory_id);
                    }
                })
                ->get();
        }

        # 課長承認
        if ($approvals->contains('approval_id', 3)) {
            $department_apps = $approvals->where('approval_id', 3);
            $users = User::with(['reports', 'remainings'])
                ->where(function ($query) use ($department_apps) {
                    foreach ($department_apps as $approval) {
                        $query->orWhere([
                            ['factory_id', $approval->factory_id],
                            ['department_id', $approval->department_id],
                        ]);
                    }
                })
                ->get();
        }

        # GL承認
        if ($approvals->contains('approval_id', 4)) {
            $group_apps = $approvals->where('approval_id', 4);
            $users = User::with(['reports', 'remainings'])
                ->where(function ($query) use ($group_apps) {
                    foreach ($group_apps as $approval) {
                        $query->orWhere([
                            ['factory_id', $approval->factory_id],
                            ['department_id', $approval->department_id],
                            ['group_id', $approval->group_id],
                        ]);
                    }
                })
                ->get();
        }

        # 閲覧
        if ($approvals->contains('approval_id', 5)) {
            $reader_apps = $approvals->where('approval_id', 5);

            # 工場全体閲覧
            if ($reader_apps->contains('department_id', 1)) {
                $users = User::with(['reports', 'remainings'])
                    ->where(function ($query) use ($reader_apps) {
                        foreach ($reader_apps as $approval) {
                            $query->orWhere(
                                'factory_id',
                                $approval->factory_id
                            );
                        }
                    })
                    ->get();
            }

            # 課全体閲覧
            if (
                !$reader_apps->contains('department_id', 1) &&
                $reader_apps->contains('group_id', 1)
            ) {
                $users = User::with(['reports', 'remainings'])
                    ->where(function ($query) use ($reader_apps) {
                        foreach ($reader_apps as $approval) {
                            $query->orWhere([
                                ['factory_id', $approval->factory_id],
                                ['department_id', $approval->department_id],
                            ]);
                        }
                    })
                    ->get();
            }

            # グループ閲覧
            if (
                !$reader_apps->contains('department_id', 1) &&
                !$reader_apps->contains('group_id', 1)
            ) {
                $users = User::with(['reports', 'remainings'])
                    ->where(function ($query) use ($reader_apps) {
                        foreach ($reader_apps as $approval) {
                            $query->orWhere([
                                ['factory_id', $approval->factory_id],
                                ['department_id', $approval->department_id],
                                ['group_id', $approval->group_id],
                            ]);
                        }
                    })
                    ->get();
            }
        }

        $report_categories = ReportCategory::all();

        return view('reports.get_and_remaining')->with(
            compact('users', 'report_categories')
        );
    }

    /** refactoring済 */
    # 承認
    public function approval(Report $report)
    {
        $approvals = Auth::user()->approvals;

        /** 通常の承認 */
        if (
            $approvals
                ->where('approval_id', 2)
                ->where('factory_id', $report->user->factory_id)
                ->where('department_id', $report->user->department_id)
                ->first()
        ) {
            $report->approval1 = 1;
        }

        if (
            $approvals
                ->where('approval_id', 2)
                ->where('factory_id', $report->user->factory_id)
                ->where('department_id', 1)
                ->first()
        ) {
            $report->approval1 = 1;
        }

        if (
            $approvals
                ->where('factory_id', $report->user->factory_id)
                ->where('department_id', $report->user->department_id)
                ->where('approval_id', 3)
                ->first()
        ) {
            $report->approval2 = 1;
        }

        if (
            $approvals
                ->where('factory_id', $report->user->factory_id)
                ->where('department_id', $report->user->department_id)
                ->where('approval_id', 4)
                ->first()
        ) {
            $report->approval3 = 1;
        }

        /** イレギュラーな承認 */
        # GLがいない部署の届を承認する
        if (
            $approvals
                ->where('factory_id', $report->user->factory_id)
                ->where('approval_id', 2)
                ->first() &&
            $report->user->group->id == 1 # グループがない
        ) {
            $report->approval1 = 1;
            $report->approval3 = 1;
        }

        if (
            $approvals
                ->where('factory_id', $report->user->factory_id)
                ->where('approval_id', 2)
                ->first() &&
            empty(
                Approval::where('factory_id', $report->user->factory_id)
                    ->where('department_id', $report->user->department_id)
                    ->where('group_id', $report->user->group_id)
                    ->first()
            ) # GLがいない
        ) {
            $report->approval1 = 1;
            $report->approval3 = 1;
        }

        if (
            $approvals
                ->where('factory_id', $report->user->factory_id)
                ->where('approval_id', 3)
                ->first() &&
            $report->user->group->id == 1
        ) {
            $report->approval2 = 1;
            $report->approval3 = 1;
        }

        if (
            $approvals
                ->where('factory_id', $report->user->factory_id)
                ->where('approval_id', 3)
                ->first() &&
            empty(
                Approval::where('factory_id', $report->user->factory_id)
                    ->where('department_id', $report->user->department_id)
                    ->where('group_id', $report->user->group_id)
                    ->first()
            ) # GLがいない
        ) {
            $report->approval2 = 1;
            $report->approval3 = 1;
        }

        /** すべて承認された場合、remainingを更新 */
        if (
            ($report->approval1 == 1 && $report->approval2 == 1) || # 工場長,課長承認
            ($report->approval1 == 1 && $report->approval3 == 1) || # 工場長,GL承認
            ($report->approval2 == 1 && $report->approval3 == 1) # 課長,GL承認
        ) {
            $report->approved = 1; # 確定
            DB::beginTransaction(); # トランザクション開始
            try {
                $report->save();
                $report_id = $report->report_id;
                $remaining = Remaining::where('user_id', $report->user_id)
                    ->where('report_id', '=', $report_id)
                    ->first();
                if (!empty($remaining)) {
                    $new_remaining = $remaining->remaining - $report->get_days;
                    $remaining->remaining = $new_remaining;
                    $remaining->save(); # 残日数を保存
                }
                DB::commit(); # トランザクション成功終了
                $user = $report->user()->first();
                $user->approved($report); # 届出作成者に承認を通知
                return redirect()
                    ->route('reports.show', $report)
                    ->with('msg', '届出が承認されました');
            } catch (\Exception $e) {
                DB::rollBack(); # トランザクション失敗終了
                return back()
                    ->withInput()
                    ->withErrors($e->getMessage());
            }
        } else {
            try {
                $report->save(); # 承認を保存
                return redirect()
                    ->route('reports.show', $report)
                    ->with('msg', '承認しました');
            } catch (\Throwable $th) {
                return back()->withErrors($th->getMessage());
            }
        }
    }

    /** refactoring済 */
    # 承認取消
    public function approvalCancel(Report $report)
    {
        $approvals = Auth::user()->approvals;

        /** 通常の承認取消*/
        if (
            $approvals
                ->where('factory_id', $report->user->factory_id)
                ->where('approval_id', 2)
                ->first()
        ) {
            $report->approval1 = 0;
        }

        if (
            $approvals
                ->where('factory_id', $report->user->factory_id)
                ->where('department_id', $report->user->department_id)
                ->where('approval_id', 3)
                ->first()
        ) {
            $report->approval2 = 0;
        }

        /** イレギュラーな承認取消*/
        # GLがいない部署の届を承認取消
        if (
            $approvals->contains('approval_id', 2) &&
            $report->user->group->id == 1
        ) {
            $report->approval1 = 0;
            $report->approval2 = 0;
        }

        /** すべて確認された場合、remainingを更新 */
        if (
            $report->cancel == 1 &&
            $report->approval1 == 0 &&
            $report->approval2 == 0
        ) {
            switch ($report->approved) {
                case 0: # 未承認の届の場合
                    try {
                        $report->delete();
                        return redirect()
                            ->route('reports.approved')
                            ->with('notice', '届出を取り消しました');
                    } catch (\Throwable $th) {
                        return back()->withErrors($th->getMessage());
                    }
                    break;

                case 1: # 承認済みの届の場合
                    // self::approvedDelete($report); これだとredirectで迷子
                    $remaining = Remaining::all()
                        ->where('report_id', '=', $report->report_id)
                        ->where('user_id', '=', $report->user_id)
                        ->first();
                    if (empty($remaining)) {
                        # remainingがない場合
                        try {
                            $report->delete();
                            return redirect()
                                ->route('reports.approved')
                                ->with('notice', '届出を取り消しました');
                        } catch (\Throwable $th) {
                            return back()->withErrors($th->getMessage());
                        }
                    } else {
                        # remainingがある場合
                        /** 残日数加算&届け取消 */
                        $remaining->remaining += $report->get_days;
                        DB::beginTransaction(); # トランザクション開始
                        try {
                            $remaining->save();
                            $report->delete();

                            DB::commit(); # トランザクション成功終了
                            return redirect()
                                ->route('reports.approved')
                                ->with('notice', '届出を取り消しました');
                        } catch (\Throwable $th) {
                            DB::rollBack(); # トランザクション失敗終了
                            return back()->withErrors($th->getMessage());
                        }
                    }
                    break;
            }
        } else {
            try {
                $report->save(); # 承認を保存
                return redirect()
                    ->route('reports.show', $report)
                    ->with('msg', '確認しました。');
            } catch (\Throwable $th) {
                return back()->withErrors($th->getMessage());
            }
        }
    }

    public function menu()
    {
        $approvals = Auth::user()->approvals;
        $birthday = new Carbon(
            Carbon::now()->year . '-' . Auth::user()->birthday
        ); # 誕生日
        if (Carbon::now()->month >= 4) {
            $year_end = new Carbon(Carbon::now()->addYear()->year . '-03-31'); # 年度末日
        } else {
            $year_end = new Carbon(Carbon::now()->year . '-03-31'); # 年度末日
        } # 年度末を年明け前後で同じ日付になるように定義
        $reports = '';
        $pending = '';
        $approved = '';
        // $birthday = new Carbon('2023-02-22');
        // $year_end = new Carbon('2023-06-06');

        /** 承認待ち件数 */
        $reports = new Collection(); # 空箱用意
        # 課ごとの工場長承認:課長がいる工場
        if (
            $approvals
                ->where('approval_id', 2)
                ->where('department_id', '!=', 1) # 課ごと
                ->first()
        ) {
            // $reports = new Collection(); # 空箱用意
            $factory_approvals = $approvals
                ->where('approval_id', 2)
                ->where('department_id', '!=', 1);
            foreach ($factory_approvals as $approval) {
                # 管轄内のreportsを取得
                $factory_reports = Report::whereHas('user', function (
                    $query
                ) use ($approval) {
                    $query
                        ->where('factory_id', $approval->factory_id)
                        ->where('department_id', $approval->department_id);
                })
                    # 未承諾を取得
                    ->where(function ($query) {
                        $query
                            ->where('cancel', 0)
                            ->where('approved', 0)
                            ->where('approval1', 0);
                    })
                    # 未確認を取得
                    ->orWhere(function ($query) {
                        $query
                            ->where('cancel', 1)
                            ->where('approved', 0)
                            ->where('approval1', 1);
                    })
                    ->get();

                # 箱に対象reportを入れる
                $factory_reports->each(function ($factory_report) use (
                    $reports
                ) {
                    $reports->add($factory_report);
                });
            }
        }

        # 包括工場長承認:課長がいない工場
        if (
            $approvals
                ->where('approval_id', 2)
                ->where('department_id', 1) # 全課
                ->first()
        ) {
            // $reports = new Collection(); # 空箱用意
            $factory_approvals = $approvals
                ->where('approval_id', 2)
                ->where('department_id', 1);
            foreach ($factory_approvals as $approval) {
                # 管轄内のreportsを取得
                $factory_reports = Report::whereHas('user', function (
                    $query
                ) use ($approval) {
                    $query->where('factory_id', $approval->factory_id);
                })
                    # 未承諾を取得
                    ->where(function ($query) {
                        $query
                            ->where('cancel', 0)
                            ->where('approved', 0)
                            ->where('approval1', 0);
                    })
                    # 未確認を取得
                    ->orWhere(function ($query) {
                        $query
                            ->where('cancel', 1)
                            ->where('approved', 0)
                            ->where('approval1', 1);
                    })
                    ->get();

                # 箱に対象reportを入れる
                $factory_reports->each(function ($factory_report) use (
                    $reports
                ) {
                    $reports->add($factory_report);
                });
            }
        }

        # 課長承認
        if ($approvals->contains('approval_id', 3)) {
            $department_approvals = $approvals->where('approval_id', 3);
            foreach ($department_approvals as $approval) {
                # 管轄内のreportsを取得
                $department_reports = Report::whereHas('user', function (
                    $query
                ) use ($approval) {
                    $query
                        ->where('factory_id', $approval->factory_id)
                        ->where('department_id', $approval->department_id);
                })
                    # 未承認を取得
                    ->where(function ($query) {
                        $query
                            ->where('cancel', 0)
                            ->where('approved', 0)
                            ->where('approval2', 0);
                    })
                    # 未確認を取得
                    ->orWhere(function ($query) {
                        $query
                            ->where('cancel', 1)
                            ->where('approved', 0)
                            ->where('approval2', 1);
                    })
                    ->get();

                # 箱に対象reportを入れる
                $department_reports->each(function ($group_report) use (
                    $reports
                ) {
                    $reports->add($group_report);
                });
            }
        }

        # GL承認
        if ($approvals->contains('approval_id', 4)) {
            // $reports = new Collection(); # 空箱用意
            $group_approvals = $approvals->where('approval_id', 4);
            foreach ($group_approvals as $approval) {
                # 管轄内のreportsを取得
                $group_reports = Report::whereHas('user', function (
                    $query
                ) use ($approval) {
                    $query
                        ->where('factory_id', $approval->factory_id)
                        ->where('department_id', $approval->department_id)
                        ->where('group_id', $approval->group_id);
                })
                    # 未承認を取得
                    ->where(function ($query) {
                        $query
                            ->where('cancel', 0)
                            ->where('approved', 0)
                            ->where('approval3', 0);
                    })
                    # 未確認を取得
                    ->orWhere(function ($query) {
                        $query
                            ->where('cancel', 1)
                            ->where('approved', 0)
                            ->where('approval3', 1);
                    })
                    ->get();

                # 箱に対象reportを入れる
                $group_reports->each(function ($group_report) use ($reports) {
                    $reports->add($group_report);
                });
            }
        }

        $reports = $reports->unique(); # 重複削除
        # 承認待ち件数count
        if (!empty($reports)) {
            $pending = count($reports);
            $reports = ''; # リセット
        } else {
            $pending = 0;
        }

        /** 承認済みの取消確認件数 */
        $reports = new Collection(); # 空箱用意
        # 課ごとの工場長承認:課長がいる工場
        if (
            $approvals
                ->where('approval_id', 2)
                ->where('department_id', '!=', 1) # 課ごと
                ->first()
        ) {
            // $reports = new Collection(); # 空箱用意
            $factory_approvals = $approvals
                ->where('approval_id', 2)
                ->where('department_id', '!=', 1);
            foreach ($factory_approvals as $approval) {
                # 管轄内のreportsを取得
                $factory_reports = Report::whereHas('user', function (
                    $query
                ) use ($approval) {
                    $query
                        ->where('factory_id', $approval->factory_id)
                        ->where('department_id', $approval->department_id);
                })
                    # 未確認を取得
                    ->where(function ($query) {
                        $query
                            ->where('cancel', 1)
                            ->where('approved', 1)
                            ->where('approval1', 1);
                    })
                    ->get();

                # 箱に対象reportを入れる
                $factory_reports->each(function ($factory_report) use (
                    $reports
                ) {
                    $reports->add($factory_report);
                });
            }
        }

        # 包括工場長承認:課長がいない工場
        if (
            $approvals
                ->where('approval_id', 2)
                ->where('department_id', 1) # 全課
                ->first()
        ) {
            // $reports = new Collection(); # 空箱用意
            $factory_approvals = $approvals
                ->where('approval_id', 2)
                ->where('department_id', 1);
            foreach ($factory_approvals as $approval) {
                # 管轄内のreportsを取得
                $factory_reports = Report::whereHas('user', function (
                    $query
                ) use ($approval) {
                    $query
                        ->where('factory_id', $approval->factory_id)
                        ->where('department_id', $approval->department_id);
                })
                    # 未確認を取得
                    ->where(function ($query) {
                        $query
                            ->where('cancel', 1)
                            ->where('approved', 1)
                            ->where('approval1', 1);
                    })
                    ->get();

                # 箱に対象reportを入れる
                $factory_reports->each(function ($factory_report) use (
                    $reports
                ) {
                    $reports->add($factory_report);
                });
            }
        }

        # 課長承認
        if ($approvals->contains('approval_id', 3)) {
            foreach ($group_approvals as $approval) {
                # 管轄内のreportsを取得
                $group_reports = Report::whereHas('user', function (
                    $query
                ) use ($approval) {
                    $query
                        ->where('factory_id', $approval->factory_id)
                        ->where('department_id', $approval->department_id);
                })
                    # 未確認を取得
                    ->where(function ($query) {
                        $query
                            ->where('cancel', 1)
                            ->where('approved', 1)
                            ->where('approval2', 1);
                    })
                    ->get();

                # 箱に対象reportを入れる
                $group_reports->each(function ($group_report) use ($reports) {
                    $reports->add($group_report);
                });
            }
        }

        # GL承認
        if ($approvals->contains('approval_id', 4)) {
            // $reports = new Collection(); # 空箱用意
            foreach ($group_approvals as $approval) {
                # 管轄内のreportsを取得
                $group_reports = Report::whereHas('user', function (
                    $query
                ) use ($approval) {
                    $query
                        ->where('factory_id', $approval->factory_id)
                        ->where('department_id', $approval->department_id)
                        ->where('group_id', $approval->group_id);
                })
                    # 未確認を取得
                    ->where(function ($query) {
                        $query
                            ->where('cancel', 1)
                            ->where('approved', 1)
                            ->where('approval3', 1);
                    })
                    ->get();

                # 箱に対象reportを入れる
                $group_reports->each(function ($group_report) use ($reports) {
                    $reports->add($group_report);
                });
            }
        }

        $reports = $reports->unique(); # 重複削除
        # 承認済みの取消確認件数count
        if (!empty($reports)) {
            $approved = count($reports);
        } else {
            $approved = 0;
        }

        /** 有休残日数 */
        $paid_holidays = Auth::user()
            ->remainings->where('report_id', 1)
            ->first();

        /** 有休失効日数 */
        $lost_paid_holidays = Auth::user()->lost_paid_holidays;

        /** 有休取得日数 */
        $get_paid_holidays = 0;
        if (Auth::user()->sum_get_days->first()) {
            $get_paid_holidays = Auth::user()->sum_get_paid_holidays;
        }

        // // ユーザー並び替え
        // $faker = Factory::create('ja_JP');
        // $param = [
        //     [
        //         'name' => '佐藤昭彦',
        //         'email' => '392@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('392'), // 社員番号+ランダム数字3桁
        //         'employee' => 392,
        //         'factory_id' => 1,
        //         'department_id' => 5,
        //         'group_id' => 1,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-19',
        //     ],
        //     [
        //         'name' => '千葉　伸',
        //         'email' => '618@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('618'), // 社員番号+ランダム数字3桁
        //         'employee' => 618,
        //         'factory_id' => 1,
        //         'department_id' => 2,
        //         'group_id' => 1,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '今野 祐香',
        //         'email' => '506@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('506'), // 社員番号+ランダム数字3桁
        //         'employee' => 506,
        //         'factory_id' => 1,
        //         'department_id' => 2,
        //         'group_id' => 1,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '菅原　麻由子',
        //         'email' => '616@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('616'), // 社員番号+ランダム数字3桁
        //         'employee' => 616,
        //         'factory_id' => 1,
        //         'department_id' => 2,
        //         'group_id' => 1,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '佐藤 友南',
        //         'email' => '682@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('682'), // 社員番号+ランダム数字3桁
        //         'employee' => 682,
        //         'factory_id' => 1,
        //         'department_id' => 2,
        //         'group_id' => 1,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '岩淵 信之',
        //         'email' => '475@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('475'), // 社員番号+ランダム数字3桁
        //         'employee' => 475,
        //         'factory_id' => 1,
        //         'department_id' => 3,
        //         'group_id' => 1,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '千葉 新治',
        //         'email' => '176@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('176'), // 社員番号+ランダム数字3桁
        //         'employee' => 176,
        //         'factory_id' => 1,
        //         'department_id' => 3,
        //         'group_id' => 2,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '沼倉　淳',
        //         'email' => '75@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('75'), // 社員番号+ランダム数字3桁
        //         'employee' => 75,
        //         'factory_id' => 1,
        //         'department_id' => 3,
        //         'group_id' => 2,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '木村 勝枝',
        //         'email' => '144@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('144'), // 社員番号+ランダム数字3桁
        //         'employee' => 144,
        //         'factory_id' => 1,
        //         'department_id' => 3,
        //         'group_id' => 2,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '那須野 定',
        //         'email' => '490@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('490'), // 社員番号+ランダム数字3桁
        //         'employee' => 490,
        //         'factory_id' => 1,
        //         'department_id' => 3,
        //         'group_id' => 2,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '齋藤 北斗',
        //         'email' => '574@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('574'), // 社員番号+ランダム数字3桁
        //         'employee' => 574,
        //         'factory_id' => 1,
        //         'department_id' => 3,
        //         'group_id' => 2,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '岩渕　昭一',
        //         'email' => '614@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('614'), // 社員番号+ランダム数字3桁
        //         'employee' => 614,
        //         'factory_id' => 1,
        //         'department_id' => 3,
        //         'group_id' => 2,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '佐藤　健治',
        //         'email' => '706@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('706'), // 社員番号+ランダム数字3桁
        //         'employee' => 706,
        //         'factory_id' => 1,
        //         'department_id' => 3,
        //         'group_id' => 2,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '千葉　茂',
        //         'email' => '16@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('16'), // 社員番号+ランダム数字3桁
        //         'employee' => 16,
        //         'factory_id' => 1,
        //         'department_id' => 3,
        //         'group_id' => 2,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '菅原 綾',
        //         'email' => '577@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('577'), // 社員番号+ランダム数字3桁
        //         'employee' => 577,
        //         'factory_id' => 1,
        //         'department_id' => 3,
        //         'group_id' => 2,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '岩渕　宏',
        //         'email' => '34@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('34'), // 社員番号+ランダム数字3桁
        //         'employee' => 34,
        //         'factory_id' => 1,
        //         'department_id' => 3,
        //         'group_id' => 2,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '阿部　敏久',
        //         'email' => '416@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('416'), // 社員番号+ランダム数字3桁
        //         'employee' => 416,
        //         'factory_id' => 1,
        //         'department_id' => 3,
        //         'group_id' => 2,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '岩淵 信之',
        //         'email' => '28@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('28'), // 社員番号+ランダム数字3桁
        //         'employee' => 28,
        //         'factory_id' => 1,
        //         'department_id' => 3,
        //         'group_id' => 3,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '佐藤 欣也',
        //         'email' => '69@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('69'), // 社員番号+ランダム数字3桁
        //         'employee' => 69,
        //         'factory_id' => 1,
        //         'department_id' => 3,
        //         'group_id' => 3,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '鈴木 良樹',
        //         'email' => '546@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('546'), // 社員番号+ランダム数字3桁
        //         'employee' => 546,
        //         'factory_id' => 1,
        //         'department_id' => 3,
        //         'group_id' => 3,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '猪岡 英宣',
        //         'email' => '552@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('552'), // 社員番号+ランダム数字3桁
        //         'employee' => 552,
        //         'factory_id' => 1,
        //         'department_id' => 3,
        //         'group_id' => 3,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '佐藤　憲一',
        //         'email' => '570@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('570'), // 社員番号+ランダム数字3桁
        //         'employee' => 570,
        //         'factory_id' => 1,
        //         'department_id' => 3,
        //         'group_id' => 3,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '小松 勇児',
        //         'email' => '613@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('613'), // 社員番号+ランダム数字3桁
        //         'employee' => 613,
        //         'factory_id' => 1,
        //         'department_id' => 3,
        //         'group_id' => 3,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '小田中 秀樹',
        //         'email' => '635@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('635'), // 社員番号+ランダム数字3桁
        //         'employee' => 635,
        //         'factory_id' => 1,
        //         'department_id' => 3,
        //         'group_id' => 3,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '氏家　達也',
        //         'email' => '665@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('665'), // 社員番号+ランダム数字3桁
        //         'employee' => 665,
        //         'factory_id' => 1,
        //         'department_id' => 3,
        //         'group_id' => 3,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '佐藤　誠',
        //         'email' => '411@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('411'), // 社員番号+ランダム数字3桁
        //         'employee' => 411,
        //         'factory_id' => 1,
        //         'department_id' => 1,
        //         'group_id' => 1,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '金田 政樹',
        //         'email' => '302@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('302'), // 社員番号+ランダム数字3桁
        //         'employee' => 302,
        //         'factory_id' => 1,
        //         'department_id' => 4,
        //         'group_id' => 4,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '吉家 勝之',
        //         'email' => '17@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('17'), // 社員番号+ランダム数字3桁
        //         'employee' => 17,
        //         'factory_id' => 1,
        //         'department_id' => 4,
        //         'group_id' => 4,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '菅原 富男',
        //         'email' => '177@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('177'), // 社員番号+ランダム数字3桁
        //         'employee' => 177,
        //         'factory_id' => 1,
        //         'department_id' => 4,
        //         'group_id' => 4,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '遠藤 悦子',
        //         'email' => '575@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('575'), // 社員番号+ランダム数字3桁
        //         'employee' => 575,
        //         'factory_id' => 1,
        //         'department_id' => 4,
        //         'group_id' => 4,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '渡辺　剛',
        //         'email' => '42@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('42'), // 社員番号+ランダム数字3桁
        //         'employee' => 42,
        //         'factory_id' => 1,
        //         'department_id' => 4,
        //         'group_id' => 5,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '菅原 勝明',
        //         'email' => '68@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('68'), // 社員番号+ランダム数字3桁
        //         'employee' => 68,
        //         'factory_id' => 1,
        //         'department_id' => 4,
        //         'group_id' => 5,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '鈴木 立萍',
        //         'email' => '370@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('370'), // 社員番号+ランダム数字3桁
        //         'employee' => 370,
        //         'factory_id' => 1,
        //         'department_id' => 4,
        //         'group_id' => 5,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '田村 和之',
        //         'email' => '397@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('397'), // 社員番号+ランダム数字3桁
        //         'employee' => 397,
        //         'factory_id' => 1,
        //         'department_id' => 4,
        //         'group_id' => 5,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '菊地 嵩斗',
        //         'email' => '565@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('565'), // 社員番号+ランダム数字3桁
        //         'employee' => 565,
        //         'factory_id' => 1,
        //         'department_id' => 4,
        //         'group_id' => 5,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '松田　伸一',
        //         'email' => '610@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('610'), // 社員番号+ランダム数字3桁
        //         'employee' => 610,
        //         'factory_id' => 1,
        //         'department_id' => 4,
        //         'group_id' => 5,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '千葉　花那',
        //         'email' => '698@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('698'), // 社員番号+ランダム数字3桁
        //         'employee' => 698,
        //         'factory_id' => 1,
        //         'department_id' => 4,
        //         'group_id' => 5,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '小野寺 純',
        //         'email' => '259@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('259'), // 社員番号+ランダム数字3桁
        //         'employee' => 259,
        //         'factory_id' => 1,
        //         'department_id' => 4,
        //         'group_id' => 5,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '山本　恵子',
        //         'email' => '63@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('63'), // 社員番号+ランダム数字3桁
        //         'employee' => 63,
        //         'factory_id' => 1,
        //         'department_id' => 5,
        //         'group_id' => 6,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '渡辺　久美',
        //         'email' => '94@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('94'), // 社員番号+ランダム数字3桁
        //         'employee' => 94,
        //         'factory_id' => 1,
        //         'department_id' => 5,
        //         'group_id' => 6,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '米倉　美月',
        //         'email' => '631@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('631'), // 社員番号+ランダム数字3桁
        //         'employee' => 631,
        //         'factory_id' => 1,
        //         'department_id' => 5,
        //         'group_id' => 6,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '岩渕 てい子',
        //         'email' => '90@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('90'), // 社員番号+ランダム数字3桁
        //         'employee' => 90,
        //         'factory_id' => 1,
        //         'department_id' => 5,
        //         'group_id' => 7,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '千葉　優二',
        //         'email' => '249@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('249'), // 社員番号+ランダム数字3桁
        //         'employee' => 249,
        //         'factory_id' => 1,
        //         'department_id' => 5,
        //         'group_id' => 7,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '千葉　博',
        //         'email' => '334@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('334'), // 社員番号+ランダム数字3桁
        //         'employee' => 334,
        //         'factory_id' => 1,
        //         'department_id' => 5,
        //         'group_id' => 7,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '千葉　梢',
        //         'email' => '449@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('449'), // 社員番号+ランダム数字3桁
        //         'employee' => 449,
        //         'factory_id' => 1,
        //         'department_id' => 5,
        //         'group_id' => 7,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '千葉 和俊',
        //         'email' => '488@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('488'), // 社員番号+ランダム数字3桁
        //         'employee' => 488,
        //         'factory_id' => 1,
        //         'department_id' => 6,
        //         'group_id' => 1,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '小野 裕一',
        //         'email' => '51@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('51'), // 社員番号+ランダム数字3桁
        //         'employee' => 51,
        //         'factory_id' => 1,
        //         'department_id' => 6,
        //         'group_id' => 8,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '須藤三樹夫',
        //         // 'email' => '366@mailaddress.com', // 社員番号@mailaddress.com
        //         'email' => 'nyantoroman@yahoo.co.jp', // 社員番号@mailaddress.com
        //         'password' => bcrypt('366'), // 社員番号+ランダム数字3桁
        //         'employee' => 366,
        //         'factory_id' => 1,
        //         'department_id' => 7,
        //         'group_id' => 1,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '浅利　摩実',
        //         'email' => '201@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('201'), // 社員番号+ランダム数字3桁
        //         'employee' => 201,
        //         'factory_id' => 1,
        //         'department_id' => 7,
        //         'group_id' => 1,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '千葉　寛子',
        //         'email' => '214@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('214'), // 社員番号+ランダム数字3桁
        //         'employee' => 214,
        //         'factory_id' => 1,
        //         'department_id' => 7,
        //         'group_id' => 1,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '松井　むつみ',
        //         'email' => '640@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('640'), // 社員番号+ランダム数字3桁
        //         'employee' => 640,
        //         'factory_id' => 1,
        //         'department_id' => 7,
        //         'group_id' => 1,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '蜂谷　昭子',
        //         'email' => '499@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('499'), // 社員番号+ランダム数字3桁
        //         'employee' => 499,
        //         'factory_id' => 1,
        //         'department_id' => 7,
        //         'group_id' => 1,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '熊谷琴美',
        //         'email' => '724@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('724'), // 社員番号+ランダム数字3桁
        //         'employee' => 724,
        //         'factory_id' => 1,
        //         'department_id' => 8,
        //         'group_id' => 1,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '八重樫美菜',
        //         'email' => '733@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('733'), // 社員番号+ランダム数字3桁
        //         'employee' => 733,
        //         'factory_id' => 1,
        //         'department_id' => 8,
        //         'group_id' => 1,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '松本英之',
        //         'email' => '734@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('734'), // 社員番号+ランダム数字3桁
        //         'employee' => 734,
        //         'factory_id' => 1,
        //         'department_id' => 8,
        //         'group_id' => 1,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     # 前沢工場
        //     [
        //         'name' => '佐藤　秀紀',
        //         'email' => '425@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('425'), // 社員番号+ランダム数字3桁
        //         'employee' => 425,
        //         'factory_id' => 2,
        //         'department_id' => 1,
        //         'group_id' => 1,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '鈴木　和夫',
        //         'email' => '398@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('398'), // 社員番号+ランダム数字3桁
        //         'employee' => 398,
        //         'factory_id' => 2,
        //         'department_id' => 9,
        //         'group_id' => 9,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '浅野　正弘',
        //         'email' => '14@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('14'), // 社員番号+ランダム数字3桁
        //         'employee' => 14,
        //         'factory_id' => 2,
        //         'department_id' => 9,
        //         'group_id' => 9,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '金野　寛子',
        //         'email' => '384@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('384'), // 社員番号+ランダム数字3桁
        //         'employee' => 384,
        //         'factory_id' => 2,
        //         'department_id' => 9,
        //         'group_id' => 10,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '菊地　さとみ',
        //         'email' => '278@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('278'), // 社員番号+ランダム数字3桁
        //         'employee' => 278,
        //         'factory_id' => 2,
        //         'department_id' => 9,
        //         'group_id' => 10,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '鈴木　綾海',
        //         'email' => '699@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('699'), // 社員番号+ランダム数字3桁
        //         'employee' => 699,
        //         'factory_id' => 2,
        //         'department_id' => 9,
        //         'group_id' => 10,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '千田　りん子',
        //         'email' => '424@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('424'), // 社員番号+ランダム数字3桁
        //         'employee' => 424,
        //         'factory_id' => 2,
        //         'department_id' => 9,
        //         'group_id' => 10,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '千葉　潤',
        //         'email' => '593@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('593'), // 社員番号+ランダム数字3桁
        //         'employee' => 593,
        //         'factory_id' => 2,
        //         'department_id' => 9,
        //         'group_id' => 10,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '永澤　祐太',
        //         'email' => '339@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('339'), // 社員番号+ランダム数字3桁
        //         'employee' => 339,
        //         'factory_id' => 2,
        //         'department_id' => 6,
        //         'group_id' => 11,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '高橋　敏春',
        //         'email' => '252@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('252'), // 社員番号+ランダム数字3桁
        //         'employee' => 252,
        //         'factory_id' => 2,
        //         'department_id' => 6,
        //         'group_id' => 11,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '石川　勝巳',
        //         'email' => '503@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('503'), // 社員番号+ランダム数字3桁
        //         'employee' => 503,
        //         'factory_id' => 2,
        //         'department_id' => 6,
        //         'group_id' => 11,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '岩渕　涼音',
        //         'email' => '623@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('623'), // 社員番号+ランダム数字3桁
        //         'employee' => 623,
        //         'factory_id' => 2,
        //         'department_id' => 6,
        //         'group_id' => 11,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '伊藤　皓揮',
        //         'email' => '401@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('401'), // 社員番号+ランダム数字3桁
        //         'employee' => 401,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 12,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '佐藤　貴志',
        //         'email' => '248@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('248'), // 社員番号+ランダム数字3桁
        //         'employee' => 248,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 12,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '大内　涼',
        //         'email' => '521@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('521'), // 社員番号+ランダム数字3桁
        //         'employee' => 521,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 12,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '加藤　優和',
        //         'email' => '655@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('655'), // 社員番号+ランダム数字3桁
        //         'employee' => 655,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 12,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '小岩　肇',
        //         'email' => '189@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('189'), // 社員番号+ランダム数字3桁
        //         'employee' => 189,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 13,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '柴田 恵美子',
        //         'email' => '332@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('332'), // 社員番号+ランダム数字3桁
        //         'employee' => 332,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 13,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '佐藤　花菜',
        //         'email' => '703@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('703'), // 社員番号+ランダム数字3桁
        //         'employee' => 703,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 13,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '佐藤　渓介',
        //         'email' => '714@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('714'), // 社員番号+ランダム数字3桁
        //         'employee' => 714,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 13,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '阿部　将士',
        //         'email' => '611@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('611'), // 社員番号+ランダム数字3桁
        //         'employee' => 611,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 14,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '高野　正博',
        //         'email' => '419@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('419'), // 社員番号+ランダム数字3桁
        //         'employee' => 419,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 14,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '菊地 宏輝',
        //         'email' => '558@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('558'), // 社員番号+ランダム数字3桁
        //         'employee' => 558,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 14,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '丸山　善憲',
        //         'email' => '677@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('677'), // 社員番号+ランダム数字3桁
        //         'employee' => 677,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 14,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '三浦　丈史',
        //         'email' => '681@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('681'), // 社員番号+ランダム数字3桁
        //         'employee' => 681,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 14,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '八重樫　滉',
        //         'email' => '707@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('707'), // 社員番号+ランダム数字3桁
        //         'employee' => 707,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 14,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '酒井　皇司',
        //         'email' => '709@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('709'), // 社員番号+ランダム数字3桁
        //         'employee' => 709,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 14,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '阿部　瞳',
        //         'email' => '634@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('634'), // 社員番号+ランダム数字3桁
        //         'employee' => 634,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 14,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '照井　吉次',
        //         'email' => '694@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('694'), // 社員番号+ランダム数字3桁
        //         'employee' => 694,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 14,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '境澤　実知也',
        //         'email' => '325@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('325'), // 社員番号+ランダム数字3桁
        //         'employee' => 325,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 15,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '細川　純',
        //         'email' => '450@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('450'), // 社員番号+ランダム数字3桁
        //         'employee' => 450,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 15,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '因幡 浩幸',
        //         'email' => '407@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('407'), // 社員番号+ランダム数字3桁
        //         'employee' => 407,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 15,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '吉田 洋次郎',
        //         'email' => '454@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('454'), // 社員番号+ランダム数字3桁
        //         'employee' => 454,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 15,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '菅原　孝春',
        //         'email' => '587@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('587'), // 社員番号+ランダム数字3桁
        //         'employee' => 587,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 15,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '佐藤　香奈',
        //         'email' => '588@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('588'), // 社員番号+ランダム数字3桁
        //         'employee' => 588,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 15,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '三浦　楓花',
        //         'email' => '657@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('657'), // 社員番号+ランダム数字3桁
        //         'employee' => 657,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 15,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '佐藤　由佳',
        //         'email' => '723@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('723'), // 社員番号+ランダム数字3桁
        //         'employee' => 723,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 15,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '及川蒼依',
        //         'email' => '728@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('728'), // 社員番号+ランダム数字3桁
        //         'employee' => 728,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 15,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '佐藤　賢一',
        //         'email' => '693@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('693'), // 社員番号+ランダム数字3桁
        //         'employee' => 693,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 15,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '佐々木 仁美',
        //         'email' => '716@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('716'), // 社員番号+ランダム数字3桁
        //         'employee' => 716,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 15,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '佐藤蓮太朗',
        //         'email' => '732@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('732'), // 社員番号+ランダム数字3桁
        //         'employee' => 732,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 15,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '千田　優太',
        //         'email' => '569@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('569'), // 社員番号+ランダム数字3桁
        //         'employee' => 569,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 16,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '濁沼 さつき',
        //         'email' => '213@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('213'), // 社員番号+ランダム数字3桁
        //         'employee' => 213,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 16,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '鈴木 まゆみ',
        //         'email' => '363@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('363'), // 社員番号+ランダム数字3桁
        //         'employee' => 363,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 16,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '高橋 一也',
        //         'email' => '391@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('391'), // 社員番号+ランダム数字3桁
        //         'employee' => 391,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 16,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '長前 秀幸',
        //         'email' => '515@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('515'), // 社員番号+ランダム数字3桁
        //         'employee' => 515,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 16,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '千葉　孝',
        //         'email' => '537@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('537'), // 社員番号+ランダム数字3桁
        //         'employee' => 537,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 16,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '丹野　美紗',
        //         'email' => '636@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('636'), // 社員番号+ランダム数字3桁
        //         'employee' => 636,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 16,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '高橋 悦也',
        //         'email' => '671@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('671'), // 社員番号+ランダム数字3桁
        //         'employee' => 671,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 16,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '西城　千香',
        //         'email' => '715@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('715'), // 社員番号+ランダム数字3桁
        //         'employee' => 715,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 16,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '佐々木陽人',
        //         'email' => '725@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('725'), // 社員番号+ランダム数字3桁
        //         'employee' => 725,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 16,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '小野寺美月',
        //         'email' => '726@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('726'), // 社員番号+ランダム数字3桁
        //         'employee' => 726,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 16,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '加藤　武史',
        //         'email' => '395@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('395'), // 社員番号+ランダム数字3桁
        //         'employee' => 395,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 17,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '高橋　知也',
        //         'email' => '688@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('688'), // 社員番号+ランダム数字3桁
        //         'employee' => 688,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 17,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '菊地　和哉',
        //         'email' => '514@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('514'), // 社員番号+ランダム数字3桁
        //         'employee' => 514,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 17,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '沼田　庸弥',
        //         'email' => '679@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('679'), // 社員番号+ランダム数字3桁
        //         'employee' => 679,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 17,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '三宅　敏典',
        //         'email' => '687@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('687'), // 社員番号+ランダム数字3桁
        //         'employee' => 687,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 17,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '懸田　竜馬',
        //         'email' => '708@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('708'), // 社員番号+ランダム数字3桁
        //         'employee' => 708,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 17,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '岩渕　颯',
        //         'email' => '731@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('731'), // 社員番号+ランダム数字3桁
        //         'employee' => 731,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 17,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '高橋　誠一',
        //         'email' => '721@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('721'), // 社員番号+ランダム数字3桁
        //         'employee' => 721,
        //         'factory_id' => 2,
        //         'department_id' => 10,
        //         'group_id' => 17,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '菅原　千春',
        //         'email' => '246@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('246'), // 社員番号+ランダム数字3桁
        //         'employee' => 246,
        //         'factory_id' => 2,
        //         'department_id' => 3,
        //         'group_id' => 18,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '伊藤　雪奈',
        //         'email' => '702@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('702'), // 社員番号+ランダム数字3桁
        //         'employee' => 702,
        //         'factory_id' => 2,
        //         'department_id' => 3,
        //         'group_id' => 18,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '菅原　優',
        //         'email' => '701@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('701'), // 社員番号+ランダム数字3桁
        //         'employee' => 701,
        //         'factory_id' => 2,
        //         'department_id' => 3,
        //         'group_id' => 18,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '伊藤　祐',
        //         'email' => '400@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('400'), // 社員番号+ランダム数字3桁
        //         'employee' => 400,
        //         'factory_id' => 2,
        //         'department_id' => 3,
        //         'group_id' => 2,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '阿部 真吾',
        //         'email' => '92@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('92'), // 社員番号+ランダム数字3桁
        //         'employee' => 92,
        //         'factory_id' => 2,
        //         'department_id' => 3,
        //         'group_id' => 2,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '菅原　悌',
        //         'email' => '193@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('193'), // 社員番号+ランダム数字3桁
        //         'employee' => 193,
        //         'factory_id' => 2,
        //         'department_id' => 3,
        //         'group_id' => 2,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '千葉　隆好',
        //         'email' => '196@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('196'), // 社員番号+ランダム数字3桁
        //         'employee' => 196,
        //         'factory_id' => 2,
        //         'department_id' => 3,
        //         'group_id' => 2,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '三浦 　実',
        //         'email' => '383@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('383'), // 社員番号+ランダム数字3桁
        //         'employee' => 383,
        //         'factory_id' => 2,
        //         'department_id' => 3,
        //         'group_id' => 2,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '千田　瀬成',
        //         'email' => '541@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('541'), // 社員番号+ランダム数字3桁
        //         'employee' => 541,
        //         'factory_id' => 2,
        //         'department_id' => 3,
        //         'group_id' => 2,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '菅原 佳己',
        //         'email' => '582@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('582'), // 社員番号+ランダム数字3桁
        //         'employee' => 582,
        //         'factory_id' => 2,
        //         'department_id' => 3,
        //         'group_id' => 2,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '高橋　秀斗',
        //         'email' => '624@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('624'), // 社員番号+ランダム数字3桁
        //         'employee' => 624,
        //         'factory_id' => 2,
        //         'department_id' => 3,
        //         'group_id' => 2,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '小部　裕',
        //         'email' => '683@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('683'), // 社員番号+ランダム数字3桁
        //         'employee' => 683,
        //         'factory_id' => 2,
        //         'department_id' => 3,
        //         'group_id' => 2,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '菅原　巧',
        //         'email' => '482@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('482'), // 社員番号+ランダム数字3桁
        //         'employee' => 482,
        //         'factory_id' => 2,
        //         'department_id' => 3,
        //         'group_id' => 2,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '小野寺　敏夫',
        //         'email' => '6@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('6'), // 社員番号+ランダム数字3桁
        //         'employee' => 6,
        //         'factory_id' => 2,
        //         'department_id' => 3,
        //         'group_id' => 19,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '阿部 龍磨',
        //         'email' => '406@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('406'), // 社員番号+ランダム数字3桁
        //         'employee' => 406,
        //         'factory_id' => 2,
        //         'department_id' => 3,
        //         'group_id' => 19,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        //     [
        //         'name' => '佐藤　建樹',
        //         'email' => '641@mailaddress.com', // 社員番号@mailaddress.com
        //         'password' => bcrypt('641'), // 社員番号+ランダム数字3桁
        //         'employee' => 641,
        //         'factory_id' => 2,
        //         'department_id' => 3,
        //         'group_id' => 19,
        //         'adoption_date' => $faker
        //             ->dateTimeBetween('-10years', '-1years')
        //             ->format('Y-m-d'),
        //         'birthday' => '5-18',
        //     ],
        // ];
        // foreach ($param as $key => $value) {
        //     $employee[$key] = $value['employee'];
        // }
        // array_multisort($employee, SORT_ASC, $param);
        // // dd($param);
        // $box = [];
        // foreach ($param as $p) {
        //     $box[] =
        //         "['name' => '" .
        //         $p['name'] .
        //         "',<br>" .
        //         "'email' => '" .
        //         $p['email'] .
        //         "',<br>" .
        //         "'password' => bcrypt(" .
        //         $p['employee'] .
        //         '),<br>' .
        //         "'employee' => " .
        //         $p['employee'] .
        //         ',<br>' .
        //         "'factory_id' => " .
        //         $p['factory_id'] .
        //         ',<br>' .
        //         "'department_id' => " .
        //         $p['department_id'] .
        //         ',<br>' .
        //         "'group_id' => " .
        //         $p['group_id'] .
        //         ',<br>' .
        //         "'adoption_date' => 0,<br>" .
        //         "'birthday' => 0,],";
        // }
        // foreach ($box as $b) {
        //     echo $b;
        // }

        return view('menu.index')->with(
            compact(
                'pending',
                'approved',
                'paid_holidays',
                'birthday',
                'year_end',
                'lost_paid_holidays',
                'get_paid_holidays'
            )
        );
    }

    public function export()
    {
        # 全データ出力
        // return Excel::download(new MixInfoExport(), 'mix_info.xlsx');

        # 帳票出力
        $reports = Report::with(
            'user',
            'report_category',
            'sub_report_category',
            'reason_category'
        )
            ->where('approved', 1)
            ->where('cancel', 0)
            ->get();
        $view = view('reports.export')->with(compact('reports'));
        return Excel::download(new ReportExport($view), 'reports.xlsx');
    }
}
