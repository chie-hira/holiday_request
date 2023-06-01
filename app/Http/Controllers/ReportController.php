<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\ReasonCategory;
use App\Models\Remaining;
use App\Models\Report;
use App\Models\ReportCategory;
use App\Models\SubReportCategory;
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

        return view('reports.create')->with(
            compact(
                'report_categories',
                'sub_report_categories',
                'reasons',
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
                        'end_date' => 'required|date|after_or_equal:start_date',
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

        $report_id = $request->report_id; // 説明変数
        $remaining = Remaining::where('user_id', '=', Auth::user()->id)
            ->where('report_id', '=', $report_id)
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
        // FIXME:reportsが重複する可能性あり

        # 閲覧
        if ($approvals->contains('approval_id', 5)) {
            $reader_apps = $approvals->where('approval_id', 5);
            # 工場全体閲覧
            if ($reader_apps->contains('department_id', 1)) {
                foreach ($reader_apps as $approval) {
                    $extractions = Report::whereHas('user', function (
                        $query
                    ) use ($approval) {
                        $query
                            ->where('factory_id', $approval->factory_id);
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
                    $query
                        ->where('factory_id', $approval->factory_id);
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
        
        $reports = $reports->unique();

        return view('reports.pending_approval')->with(compact('reports'));
    }

    # 承認済みのreports
    public function approved()
    {
        $approvals = Auth::user()->approvals;
        $reports = new Collection();
        // FIXME:reportsが重複する可能性あり

        # 閲覧
        if ($approvals->contains('approval_id', 5)) {
            $reader_apps = $approvals->where('approval_id', 5);
            # 工場全体閲覧
            if ($reader_apps->contains('department_id', 1)) {
                foreach ($reader_apps as $approval) {
                    $extractions = Report::whereHas('user', function (
                        $query
                    ) use ($approval) {
                        $query
                            ->where('factory_id', $approval->factory_id);
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
                    $query
                        ->where('factory_id', $approval->factory_id);
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

        $reports = $reports->unique();

        return view('reports.approved')->with(compact('reports'));
    }

    public function getAndRemaining()
    {
        $approvals = Auth::user()->approvals;

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

        # GL承認
        if ($approvals->contains('approval_id', 3)) {
            $group_apps = $approvals->where('approval_id', 3);
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
        if ($approvals->contains('approval_id', 4)) {
            $reader_apps = $approvals->where('approval_id', 4);

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
            empty(Approval::where('factory_id', $report->user->factory_id)
                ->where('department_id', $report->user->department_id)
                ->where('group_id', $report->user->group_id)->first()) # GLがいない
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
            empty(Approval::where('factory_id', $report->user->factory_id)
                ->where('department_id', $report->user->department_id)
                ->where('group_id', $report->user->group_id)->first()) # GLがいない
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
                return redirect()
                    ->route('reports.show', $report)
                    ->with('msg', '承認しました');
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
                    // FIXME:
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
        $year_end = new Carbon(Carbon::now()->addYear(1)->year . '-03-31'); # 年度末日
        $reports = '';
        $pending = '';
        $approved = '';
        // $birthday = new Carbon('2023-02-22');
        // $year_end = new Carbon('2023-06-06');

        /** 承認待ち件数 */
        # 課ごとの工場長承認:課長がいる工場
        if (
            $approvals
                ->where('approval_id', 2)
                ->where('department_id', '!=', 1) # 課ごと
                ->first()
        ) {
            $reports = new Collection(); # 空箱用意
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
            $reports = new Collection(); # 空箱用意
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
            $reports = new Collection(); # 空箱用意
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

        // FIXME:課長権限とGL権限の両方を持つと$reportsが上書きされる
        # GL承認
        if ($approvals->contains('approval_id', 4)) {
            $reports = new Collection(); # 空箱用意
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

        # 承認待ち件数count
        if (!empty($reports)) {
            $pending = count($reports);
            $reports = ''; # リセット
        } else {
            $pending = 0;
        }

        /** 承認済みの取消確認件数 */
        # 課ごとの工場長承認:課長がいる工場
        if (
            $approvals
                ->where('approval_id', 2)
                ->where('department_id', '!=', 1) # 課ごと
                ->first()
        ) {
            $reports = new Collection(); # 空箱用意
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
            $reports = new Collection(); # 空箱用意
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

        # GL承認
        if ($approvals->contains('approval_id', 4)) {
            $reports = new Collection(); # 空箱用意
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
        $adoption_date_carbon = new Carbon(Auth::user()->adoption_date); # 採用年月日
        $diff = $adoption_date_carbon->diff($year_end);
        $length_of_service = floatval($diff->y . '.' . $diff->m); # 勤続年数
        $remaining_now = $paid_holidays->remaining;

        switch ($length_of_service) {
            case $length_of_service < 1.5:
                $lost_days = 0;
                break;

            case $length_of_service >= 1.5 && $length_of_service < 2.5:
                $remaining_add = $remaining_now + 11;
                if ($remaining_add > 21) {
                    $lost_days = $remaining_add - 21;
                } else {
                    $lost_days = 0;
                }
                break;

            case $length_of_service >= 2.5 && $length_of_service < 3.5:
                $remaining_add = $remaining_now + 12;
                if ($remaining_add > 23) {
                    $lost_days = $remaining_add - 23;
                } else {
                    $lost_days = 0;
                }
                break;

            case $length_of_service >= 3.5 && $length_of_service < 4.5:
                $remaining_add = $remaining_now + 14;
                if ($remaining_add > 26) {
                    $lost_days = $remaining_add - 26;
                } else {
                    $lost_days = 0;
                }
                break;

            case $length_of_service >= 4.5 && $length_of_service < 5.5:
                $remaining_add = $remaining_now + 16;
                if ($remaining_add > 30) {
                    $lost_days = $remaining_add - 30;
                } else {
                    $lost_days = 0;
                }
                break;

            case $length_of_service >= 5.5 && $length_of_service < 6.5:
                $remaining_add = $remaining_now + 18;
                if ($remaining_add > 32) {
                    $lost_days = $remaining_add - 32;
                } else {
                    $lost_days = 0;
                }
                break;

            case $length_of_service >= 6.5:
                $remaining_add = $remaining_now + 20;
                if ($remaining_add > 40) {
                    $lost_days = $remaining_add - 40;
                } else {
                    $lost_days = 0;
                }
                break;
        }

        /** 有休取得日数 */
        $get_days_only = 0;
        $get_days_hours = 0;
        if (Auth::user()->sum_get_days->first()) {
            $get_days_only = Auth::user()->sum_get_days_only; # 有給休暇id=1
            $get_days_hours = Auth::user()->sum_paid_holiday_hours; # 有給休暇id=1
        }

        return view('menu.index')->with(
            compact(
                'pending',
                'approved',
                'paid_holidays',
                'birthday',
                'year_end',
                'lost_days',
                'get_days_only',
                'get_days_hours'
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
