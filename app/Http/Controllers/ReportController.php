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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::all()->where('user_id', '=', Auth::user()->id);
        return view('reports.index')->with(compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $report_categories = ReportCategory::all();
        $sub_report_categories = SubReportCategory::all();
        $reasons = ReasonCategory::all();
        $my_remainings = Remaining::all()->where('user_id', '=', Auth::id());

        // 新採用・中途採用
        if (empty($my_remainings->first())) {
            $report_ids = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 16];
            foreach ($report_ids as $report_id) {
                self::newRemaining($report_id);
            }
            $my_remainings = Remaining::all()->where(
                'user_id',
                '=',
                Auth::id()
            );
        }

        return view('reports.create')->with(
            compact(
                'report_categories',
                'sub_report_categories',
                'reasons',
                'my_remainings'
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
                            'required|date|after_or_equal:report_date',
                        'end_date' => 'required|date|after_or_equal:start_date',
                        'get_days' => 'required|integer|min:1',
                    ],
                    [
                        'get_days.min' => '取得日数は1日以上です。',
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
                        'get_days.in' => '半日有休は4時間です。',
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
                    'start_date' => 'required|date|after_or_equal:report_date',
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

        try {
            $report->save();
            return redirect(route('reports.index'))->with(
                'notice',
                '出退勤届けを提出しました'
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
        $my_remainings = Remaining::all()->where('user_id', '=', Auth::id());

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

        # reportsレコード更新&承認リセット
        $report->fill($request->all());
        $report->approval1 = 0;
        $report->approval2 = 0;
        $report->approval3 = 0;

        try {
            $report->save();
            return redirect(route('reports.index'))->with(
                'notice',
                '出退勤届けを更新しました。'
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
        // FIXME:通知機能、承認途中で取り消されたら承認した人に通知、承認者が確認したらdelete

        // part1:通知 reportsテーブルcancelカラムが1
        // part2:キャンセルの確認 reportsテーブルapprovalカラムがすべて0
        // part3:削除 reportsテーブルcancelカラムが1、approvalカラムがすべて0で発動
        $report->cancel = 1;
        $report->save();

        if (
            $report->cancel == 1 &&
            $report->approval1 == 0 &&
            $report->approval2 == 0 &&
            $report->approval3 == 0
        ) {
            try {
                $report->delete();
                return redirect()
                    ->route('reports.index')
                    ->with('notice', '届けを取り消しました');
            } catch (\Throwable $th) {
                return back()->withErrors($th->getMessage());
            }
        } else {
            return redirect()
                ->route('reports.index')
                ->with('notice', '届けの取消を申請しました');
        }
    }

    /** 承認済み届出の取消申請 */
    public function approvedCancel(Report $report)
    {
        $report->cancel = 1; # キャンセルon

        $approvals = Auth::user()->approvals;

        /** 通常の承認取消*/
        if ($approvals->contains('approval_id', 1)) {
            $report->approval1 = 0;
        }

        if (
            $approvals
                ->where('factory_id', $report->user->factory_id)
                ->where('approval_id', 2)
                ->first()
        ) {
            $report->approval2 = 0;
        }

        if (
            $approvals
                ->where('factory_id', $report->user->factory_id)
                ->where('department_id', $report->user->department_id)
                ->where('approval_id', 3)
                ->first()
        ) {
            $report->approval3 = 0;
        }

        /** イレギュラーな承認取消*/
        # 会社承認者が自分の届を承認取消
        if (
            $approvals->contains('approval_id', 1) &&
            $report->user->id == Auth::user()->id
        ) {
            $report->approval1 = 0;
            $report->approval2 = 0;
            $report->approval3 = 0;
        }

        # 工場承認者が自分の届を承認取消
        if (
            $approvals->contains('approval_id', 2) &&
            $report->user->id == Auth::user()->id
        ) {
            $report->approval2 = 0;
            $report->approval3 = 0;
        }

        # GLがいない部署の届を承認取消
        if (
            $approvals->contains('approval_id', 2) &&
            $report->user->group->id == 1
        ) {
            $report->approval2 = 0;
            $report->approval3 = 0;
        }

        // $report->approval1 = 0; # 会社承認off
        // // FIXME:
        // if ($report->user->id == Auth::user()->id) {
        //     $report->approval2 = 0; # 工場承認off
        //     $report->approval3 = 0; # GL承認off
            // self::approvedDelete($report); # なぜかこれだと迷子
        //     $remaining = Remaining::all()
        //         ->where('report_id', '=', $report->report_id)
        //         ->where('user_id', '=', $report->user_id)
        //         ->first();

        //     if (empty($remaining)) {
        //         try {
        //             $report->delete();
        //             return redirect()
        //                 ->route('reports.approved')
        //                 ->with('notice', '出退勤届けを取り消しました');
        //         } catch (\Throwable $th) {
        //             return back()->withErrors($th->getMessage());
        //         }
        //     }

        //     /** 残日数加算&届け取消 */
        //     $remaining->remaining += $report->get_days;
        //     DB::beginTransaction(); # トランザクション開始
        //     try {
        //         $remaining->save();
        //         $report->delete();

        //         DB::commit(); # トランザクション成功終了
        //         return redirect()
        //             ->route('reports.approved')
        //             ->with('notice', '出退勤届けを取り消しました');
        //     } catch (\Throwable $th) {
        //         DB::rollBack(); # トランザクション失敗終了
        //         return back()->withErrors($th->getMessage());
        //     }
        // } else {
            try {
                $report->save();
                return redirect()
                    ->route('reports.approved')
                    ->with('notice', '届けの取消を申請しました');
            } catch (\Throwable $th) {
                return back()->withErrors($th->getMessage());
            }
        // }
    }

    // /** 承認済み届出の取消 */
    // public function approvedDelete(Report $report)
    // {
    //     $remaining = Remaining::all()
    //         ->where('report_id', '=', $report->report_id)
    //         ->where('user_id', '=', $report->user_id)
    //         ->first();

    //     if (empty($remaining)) {
    //         try {
    //             $report->delete();
    //             return redirect()
    //                 ->route('reports.index')
    //                 ->with('notice', '出退勤届けを取り消しました');
    //         } catch (\Throwable $th) {
    //             return back()->withErrors($th->getMessage());
    //         }
    //     }

    //     /** 残日数加算&届け取消 */
    //     $remaining->remaining += $report->get_days;
    //     DB::beginTransaction(); # トランザクション開始
    //     try {
    //         $remaining->save();
    //         $report->delete();

    //         DB::commit(); # トランザクション成功終了
    //         return redirect()
    //             ->route('reports.index')
    //             ->with('notice', '出退勤届けを取り消しました');
    //     } catch (\Throwable $th) {
    //         DB::rollBack(); # トランザクション失敗終了
    //         return back()->withErrors($th->getMessage());
    //     }
    // }

    /** refactoring未完 */
    # 承認待ちのreports
    public function pendingApproval()
    {
        $approvals = Auth::user()->approvals;

        # 閲覧
        if ($approvals->contains('approval_id', 4)) {
            $reader_apps = $approvals->where('approval_id', 4);

            # 工場全体閲覧
            if ($reader_apps->contains('department_id', 1)) {
                $reports = Report::whereHas('user', function ($query) use (
                    $reader_apps
                ) {
                    foreach ($reader_apps as $approval) {
                        $query->orWhere('factory_id', $approval->factory_id);
                    }
                })
                    ->where(function ($query) {
                        $query->where('approved', 0);
                    })
                    ->get();
            }

            # 課全体閲覧
            if (
                !$reader_apps->contains('department_id', 1) &&
                $reader_apps->contains('group_id', 1)
            ) {
                # FIXME:add方式...もっと良い方法があるはず
                $reports = new Collection();
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
                # FIXME:add方式...もっと良い方法があるはず
                $reports = new Collection();
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
        if ($approvals->contains('approval_id', 3)) {
            $group_apps = $approvals->where('approval_id', 3);
            // dd($group_apps);
            $reports = new Collection();
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

        # 工場承認
        // FIXME:同じfactory_idのapproval_id=2が複数あるとダブル計上
        // 権限のバリデーションで同じfactory_idのapproval_id=2は作成できないようにする
        if ($approvals->contains('approval_id', 2)) {
            $factory_apps = $approvals->where('approval_id', 2);
            $reports = Report::whereHas('user', function ($query) use (
                $factory_apps
            ) {
                foreach ($factory_apps as $approval) {
                    $query->orWhere('factory_id', $approval->factory_id);
                }
            })
                ->where(function ($query) {
                    $query->where('approved', 0);
                })
                ->get();
        }

        # 会社承認
        if ($approvals->contains('approval_id', 1)) {
            $reports = Report::where('approved', 0)->get();
        }

        return view('reports.pending_approval')->with(compact('reports'));
    }

    /** refactoring未完 */
    # 承認済みのreports
    public function approved()
    {
        $approvals = Auth::user()->approvals;

        # 閲覧
        if ($approvals->contains('approval_id', 4)) {
            $reader_apps = $approvals->where('approval_id', 4);

            # 工場全体閲覧
            if ($reader_apps->contains('department_id', 1)) {
                $reports = Report::whereHas('user', function ($query) use (
                    $reader_apps
                ) {
                    foreach ($reader_apps as $approval) {
                        $query->orWhere('factory_id', $approval->factory_id);
                    }
                })
                    ->where(function ($query) {
                        $query->where('approved', 1);
                    })
                    ->get();

                // $reports = new Collection();
                // foreach ($reader_apps as $approval) {
                //     $extractions = Report::whereHas('user', function ($query) use ($approval) {
                //         $query
                //             ->where('factory_id', $approval->factory_id);
                //     })
                //         ->where(function ($query) {
                //             $query->where('approved', 1);
                //         })
                //         ->get();
                //     $extractions->each(function ($extraction) use ($reports) {
                //         $reports->add($extraction);
                //     });
                // }
            }

            # 課全体閲覧
            if (
                !$reader_apps->contains('department_id', 1) &&
                $reader_apps->contains('group_id', 1)
            ) {
                # FIXME:add方式...もっと良い方法があるはず
                $reports = new Collection();
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

                // $reports = Report::whereHas('user', function ($query) use (
                //     $reader_apps
                // ) {
                //     foreach ($reader_apps as $approval) {
                //         $query->orWhere([
                //             ['factory_id', $approval->factory_id],
                //             ['department_id', $approval->department_id],
                //         ]);
                //     }
                // })
                //     ->where(function ($query) {
                //         $query->where('approved', 1);
                //     })
                //     ->get();
            }

            # グループ閲覧
            if (
                !$reader_apps->contains('department_id', 1) &&
                !$reader_apps->contains('group_id', 1)
            ) {
                # FIXME:add方式...もっと良い方法があるはず
                $reports = new Collection();
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

                // $reports = Report::whereHas('user', function ($query) use (
                //     $reader_apps
                // ) {
                //     foreach ($reader_apps as $approval) {
                //         $query->orWhere([
                //             ['factory_id', $approval->factory_id],
                //             ['department_id', $approval->department_id],
                //             ['group_id', $approval->group_id],
                //         ]);
                //     }
                // })
                //     ->where(function ($query) {
                //         $query->where('approved', 1);
                //     })
                //     ->get();
            }
        }

        # GL承認
        if ($approvals->contains('approval_id', 3)) {
            $group_apps = $approvals->where('approval_id', 3);
            # FIXME:add方式...もっと良い方法があるはず
            $reports = new Collection();
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

            // FIXME:これだとNGなぜ？？リレーション先で(A and B and C)or(A' and B' and C')or...ができない
            // $reports = Report::whereHas('user', function ($query) use (
            //         $group_apps
            //     ) {
            //         foreach ($group_apps as $approval) {
            //             $query->orWhere(function ($query) use ($approval)
            //             {
            //                 $query
            //                     ->where('factory_id', $approval->factory_id)
            //                     ->where('department_id', $approval->department_id)
            //                     ->where('group_id', $approval->group_id);
            //             });
            //             // $query->orWhere([
            //             //     ['factory_id', $approval->factory_id],
            //             //     ['department_id', $approval->department_id],
            //             //     ['group_id', $approval->group_id],
            //             // ]);
            //         }
            //     })
            //         ->where(function ($query) {
            //             $query->where('approved', 1);
            //         })
            //         ->get();
            // dd($reports);
        }

        # 工場承認
        if ($approvals->contains('approval_id', 2)) {
            $factory_apps = $approvals->where('approval_id', 2);
            $reports = Report::whereHas('user', function ($query) use (
                $factory_apps
            ) {
                foreach ($factory_apps as $approval) {
                    $query->orWhere('factory_id', $approval->factory_id);
                }
            })
                ->where(function ($query) {
                    $query->where('approved', 1);
                })
                ->get();

            // $reports = new Collection();
            // foreach ($factory_apps as $approval) {
            //     $extractions = Report::whereHas('user', function ($query) use (
            //         $approval
            //     ) {
            //         $query->where('factory_id', $approval->factory_id);
            //     })
            //         ->where(function ($query) {
            //             $query->where('approved', 1);
            //         })
            //         ->get();

            //     $extractions->each(function ($extraction) use ($reports) {
            //         $reports->add($extraction);
            //     });
            // }
        }

        # 会社承認
        if ($approvals->contains('approval_id', 1)) {
            $reports = Report::where('approved', 1)->get();
        }
        return view('reports.approved')->with(compact('reports'));
    }

    public function getAndRemaining()
    {
        $approvals = Auth::user()->approvals;

        # 会社承認
        if ($approvals->contains('approval_id', 1)) {
            $users = User::with(['reports', 'remainings'])->get();
        }

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
        if ($approvals->contains('approval_id', 1)) {
            $report->approval1 = 1;
        }

        /** containsの書き方 */
        // if($approvals->contains(function ($approval) use ($report) {
        //     return $approval->factory_id == $report->user->factory_id &&
        //     $approval->approval_id == $report->user->approval_id ;
        //     })
        // ) {
        if (
            $approvals
                ->where('factory_id', $report->user->factory_id)
                ->where('approval_id', 2)
                ->first()
        ) {
            $report->approval2 = 1;
        }

        if (
            $approvals
                ->where('factory_id', $report->user->factory_id)
                ->where('department_id', $report->user->department_id)
                ->where('approval_id', 3)
                ->first()
        ) {
            $report->approval3 = 1;
        }

        /** イレギュラーな承認*/
        # 会社承認者が自分の届を承認する
        if (
            $approvals->contains('approval_id', 1) &&
            $report->user->id == Auth::user()->id
        ) {
            $report->approval1 = 1;
            $report->approval2 = 1;
            $report->approval3 = 1;
        }

        # 工場承認者が自分の届を承認する
        if (
            $approvals->contains('approval_id', 2) &&
            $report->user->id == Auth::user()->id
        ) {
            $report->approval2 = 1;
            $report->approval3 = 1;
        }
        # GLがいない部署の届を承認する
        if (
            $approvals->contains('approval_id', 2) &&
            $report->user->group->id == 1
        ) {
            $report->approval2 = 1;
            $report->approval3 = 1;
        }

        /** すべて承認された場合、remainingを更新 */
        if (
            $report->approval1 == 1 &&
            $report->approval2 == 1 &&
            $report->approval3 == 1
        ) {
            $report->approved = 1; # 確定
            DB::beginTransaction(); # トランザクション開始
            try {
                $report->save();
                $report_id = $report->report_id;
                $remaining = Remaining::where('user_id', '=', $report->user_id)
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
                    ->with('notice', '承認しました。');
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
                    ->with('notice', '承認しました。');
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
        if ($approvals->contains('approval_id', 1)) {
            $report->approval1 = 0;
        }

        if (
            $approvals
                ->where('factory_id', $report->user->factory_id)
                ->where('approval_id', 2)
                ->first()
        ) {
            $report->approval2 = 0;
        }

        if (
            $approvals
                ->where('factory_id', $report->user->factory_id)
                ->where('department_id', $report->user->department_id)
                ->where('approval_id', 3)
                ->first()
        ) {
            $report->approval3 = 0;
        }

        /** イレギュラーな承認取消*/
        # 会社承認者が自分の届を承認取消
        if (
            $approvals->contains('approval_id', 1) &&
            $report->user->id == Auth::user()->id
        ) {
            $report->approval1 = 0;
            $report->approval2 = 0;
            $report->approval3 = 0;
        }

        # 工場承認者が自分の届を承認取消
        if (
            $approvals->contains('approval_id', 2) &&
            $report->user->id == Auth::user()->id
        ) {
            $report->approval2 = 0;
            $report->approval3 = 0;
        }

        # GLがいない部署の届を承認取消
        if (
            $approvals->contains('approval_id', 2) &&
            $report->user->group->id == 1
        ) {
            $report->approval2 = 0;
            $report->approval3 = 0;
        }

        /** すべて確認された場合、remainingを更新 */
        if (
            $report->cancel == 1 &&
            $report->approval1 == 0 &&
            $report->approval2 == 0 &&
            $report->approval3 == 0
        ) {
            switch ($report->approved) {
                case 0: # 未承認の届の場合
                    try {
                        $report->delete();
                        return redirect()
                            ->route('reports.approved')
                            ->with('notice', '届けを取り消しました');
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
                                ->with('notice', '出退勤届けを取り消しました');
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
                                ->with('notice', '出退勤届けを取り消しました');
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
                    ->with('notice', '確認しました。');
            } catch (\Throwable $th) {
                return back()->withErrors($th->getMessage());
            }
        }
    }

    /** refactoring済 */
    public function menu()
    {
        $approvals = Auth::user()->approvals;
        $reports = '';
        $pending = '';
        $approved = '';

        /** 承認待ち件数 */
        # 会社承認
        if ($approvals->contains('approval_id', 1)) {
            $reports = Report::where([
                ['cancel', 0],
                ['approved', 0],
                ['approval1', 0],
            ])
                ->orWhere([['cancel', 1], ['approved', 0], ['approval1', 1]])
                ->get();
        }

        # 工場承認
        if ($approvals->contains('approval_id', 2)) {
            $factory_approvals = $approvals->where('approval_id', 2);
            foreach ($factory_approvals as $approval) {
                # 管轄内のreportsを取得
                $factory_reports = Report::whereHas('user', function (
                    $query
                ) use ($approval) {
                    $query->where('factory_id', $approval->factory_id);
                });

                # 管轄内のreportsから未承認or未確認を取得
                $reports = $factory_reports
                    ->where(function ($query) {
                        $query
                            ->where('cancel', 0)
                            ->where('approved', 0)
                            ->where('approval2', 0);
                    })
                    ->orWhere(function ($query) {
                        $query
                            ->where('cancel', 1)
                            ->where('approved', 0)
                            ->where('approval2', 1);
                    })
                    ->get();
            }
        }

        # GL承認
        if ($approvals->contains('approval_id', 3)) {
            $group_approvals = $approvals->where('approval_id', 3);
            foreach ($group_approvals as $approval) {
                # 管轄内のreportsを取得
                $group_reports = Report::whereHas('user', function (
                    $query
                ) use ($approval) {
                    $query
                        ->where('factory_id', $approval->factory_id)
                        ->where('department_id', $approval->department_id)
                        ->where('group_id', $approval->group_id);
                });

                # 管轄内のreportsから未承認or未確認を取得
                $reports = $group_reports
                    ->where(function ($query) {
                        $query
                            ->where('cancel', 0)
                            ->where('approved', 0)
                            ->where('approval3', 0);
                    })
                    ->orWhere(function ($query) {
                        $query
                            ->where('cancel', 1)
                            ->where('approved', 0)
                            ->where('approval3', 1);
                    })
                    ->get();
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
        # 会社承認
        if ($approvals->contains('approval_id', 1)) {
            $reports = Report::where([
                ['cancel', 1],
                ['approved', 1],
                ['approval1', 1],
            ])->get();
        }

        # 工場承認
        if ($approvals->contains('approval_id', 2)) {
            // $reports = new Collection();
            foreach ($factory_approvals as $approval) {
                # 管轄内のreportsを取得
                $factory_reports = Report::whereHas('user', function (
                    $query
                ) use ($approval) {
                    $query->where('factory_id', $approval->factory_id);
                });

                # 管轄内のreportsから未確認を取得
                $reports = $factory_reports
                    ->where(function ($query) {
                        $query
                            ->where('cancel', 1)
                            ->where('approved', 1)
                            ->where('approval2', 1);
                    })
                    ->get();

                // $extractions = Report::whereHas('user', function ($query) use (
                //     $approval
                // ) {
                //     $query->where('factory_id', $approval->factory_id);
                // })
                //     ->where(function ($query) {
                //         $query
                //             ->where('cancel', 1)
                //             ->where('approved', 1)
                //             ->where('approval2', 1);
                //     })
                //     ->get();
                // $extractions->each(function ($extraction) use ($reports) {
                //     $reports->add($extraction);
                // });
            }
        }

        # GL承認
        if ($approvals->contains('approval_id', 3)) {
            // $reports = new Collection();
            foreach ($group_approvals as $approval) {
                # 管轄内のreportsを取得
                $group_reports = Report::whereHas('user', function (
                    $query
                ) use ($approval) {
                    $query
                        ->where('factory_id', $approval->factory_id)
                        ->where('department_id', $approval->department_id)
                        ->where('group_id', $approval->group_id);
                });

                # 管轄内のreportsから未承認or未確認を取得
                $reports = $group_reports
                    ->where(function ($query) {
                        $query
                            ->where('cancel', 1)
                            ->where('approved', 1)
                            ->where('approval3', 1);
                    })
                    ->get();

                // $extractions = Report::whereHas('user', function ($query) use (
                //     $approval
                // ) {
                //     $query
                //         ->where('factory_id', $approval->factory_id)
                //         ->where('department_id', $approval->department_id)
                //         ->where('group_id', $approval->group_id);
                // })
                //     ->where(function ($query) {
                //         $query
                //             ->where('cancel', 1)
                //             ->where('approved', 1)
                //             ->where('approval3', 1);
                //     })
                //     ->get();
                // $extractions->each(function ($extraction) use ($reports) {
                //     $reports->add($extraction);
                // });
            }
        }

        # 承認済みの取消確認件数count
        if (!empty($reports)) {
            $approved = count($reports);
        } else {
            $approved = 0;
        }

        $paid_holidays = Auth::user()
            ->remainings->where('report_id', 1)
            ->first();

        return view('menu.index')->with(
            compact('pending', 'approved', 'paid_holidays')
        );
    }
}
