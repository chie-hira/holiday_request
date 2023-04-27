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
            $report_ids = [1, 2, 3, 5, 6, 7, 8, 14];
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
            $request->report_id == 5 || # 特別休暇(看護・対象1名)
            $request->report_id == 6 || # 特別休暇(看護・対象2名)
            $request->report_id == 7 || # 特別休暇(介護・対象1名)
            $request->report_id == 8
        ) {
            # 特別休暇(介護・対象2名)
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
            $request->report_id == 10
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
        }
        if (
            $request->report_id == 3 || # 特別休暇(慶事)
            $request->report_id == 4 || # 特別休暇(弔事)
            $request->report_id == 9 || # 特別休暇(短期育休)
            $request->report_id == 14 || # 介護休業
            $request->report_id == 15 || # 育児休業
            $request->report_id == 16
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
        }
        if (
            $request->report_id == 11 || # 遅刻
            $request->report_id == 12
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
        }
        if ($request->report_id == 13) {
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
                '提出しました'
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
            $request->report_id == 5 || # 特別休暇(看護・対象1名)
            $request->report_id == 6 || # 特別休暇(看護・対象2名)
            $request->report_id == 7 || # 特別休暇(介護・対象1名)
            $request->report_id == 8
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
            $request->report_id == 10
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
            $request->report_id == 9 || # 特別休暇(短期育休)
            $request->report_id == 14 || # 介護休業
            $request->report_id == 15 || # 育児休業
            $request->report_id == 16
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
            $request->report_id == 11 || # 遅刻
            $request->report_id == 12
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
        if ($request->report_id == 13) {
            # 外出
            // dd($request);
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

        # reportsレコード更新
        $report->fill($request->all());

        try {
            $report->save();
            return redirect(route('reports.index'))->with(
                'notice',
                '更新しました'
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
        // FIXME:残日数を復活&認証が1つでもついたら取り消しできない
        try {
            $report->delete();
            return redirect()
                ->route('reports.index')
                ->with('notice', '届けを取り消しました');
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }

    public function approvedDelete(Report $report)
    {
        $remaining = Remaining::all()
            ->where('report_id', '=', $report->report_id)
            ->where('user_id', '=', $report->user_id)
            ->first();
        $remaining->remaining += $report->get_days;

        /** 残日数加算&届け取消 */
        DB::beginTransaction(); # トランザクション開始
        try {
            $remaining->save();
            $report->delete();

            DB::commit(); # トランザクション成功終了
            return redirect()
                ->route('reports.index')
                ->with('notice', '届けを取り消しました');
        } catch (\Throwable $th) {
            DB::rollBack(); # トランザクション失敗終了
            return back()->withErrors($th->getMessage());
        }
    }

    public function approvalPending()
    {
        $user = Auth::user();
        if (
            !empty(
                Auth::user()
                    ->approvals->where('approval_id', '=', 1)
                    ->first()
            )
        ) {
            $reports = Report::where('approval1', '=', 0)
                ->orWhere('approval2', '=', 0)
                ->orWhere('approval3', '=', 0)
                ->get();
        }

        if (
            !empty(
                Auth::user()
                    ->approvals->where('approval_id', '=', 2)
                    ->first()
            )
        ) {
            $reports = new Collection();
            foreach ($user->approvals as $approval) {
                $extractions = Report::whereHas('user', function ($query) use (
                    $approval
                ) {
                    $query->where('factory_id', $approval->factory_id);
                })
                    ->where(function ($query) {
                        $query
                            ->where('approval1', '=', 0)
                            ->orWhere('approval2', '=', 0)
                            ->orWhere('approval3', '=', 0);
                    })
                    ->get();

                $extractions->each(function ($extraction) use ($reports) {
                    $reports->add($extraction);
                });
            }
        }

        if (
            !empty(
                Auth::user()
                    ->approvals->where('approval_id', '=', 3)
                    ->first()
            )
        ) {
            $reports = new Collection();
            foreach ($user->approvals as $approval) {
                $extractions = Report::whereHas('user', function ($query) use (
                    $approval
                ) {
                    $query
                        ->where('factory_id', $approval->factory_id)
                        ->where('department_id', $approval->department_id);
                })
                    ->where(function ($query) {
                        $query
                            ->where('approval1', '=', 0)
                            ->orWhere('approval2', '=', 0)
                            ->orWhere('approval3', '=', 0);
                    })
                    ->get();

                $extractions->each(function ($extraction) use ($reports) {
                    $reports->add($extraction);
                });
            }
        }
        return view('approvals.pending')->with(compact('reports'));
    }

    public function approved()
    {
        $user = Auth::user();
        if (
            !empty(
                Auth::user()
                    ->approvals->where('approval_id', '=', 1)
                    ->first()
            )
        ) {
            $reports = Report::where('approval1', '=', 1)
                ->where('approval2', '=', 1)
                ->where('approval3', '=', 1)
                ->get();
        }

        if (
            !empty(
                Auth::user()
                    ->approvals->where('approval_id', '=', 2)
                    ->first()
            )
        ) {
            $reports = new Collection();
            foreach ($user->approvals as $approval) {
                $extractions = Report::whereHas('user', function ($query) use (
                    $approval
                ) {
                    $query->where('factory_id', $approval->factory_id);
                })
                    ->where(function ($query) {
                        $query
                            ->where('approval1', '=', 1)
                            ->where('approval2', '=', 1)
                            ->where('approval3', '=', 1);
                    })
                    ->get();

                $extractions->each(function ($extraction) use ($reports) {
                    $reports->add($extraction);
                });
            }
        }

        if (
            !empty(
                Auth::user()
                    ->approvals->where('approval_id', '=', 3)
                    ->first()
            )
        ) {
            $reports = new Collection();
            foreach ($user->approvals as $approval) {
                $extractions = Report::whereHas('user', function ($query) use (
                    $approval
                ) {
                    $query
                        ->where('factory_id', $approval->factory_id)
                        ->where('department_id', $approval->department_id);
                })
                    ->where(function ($query) {
                        $query
                            ->where('approval1', '=', 1)
                            ->where('approval2', '=', 1)
                            ->where('approval3', '=', 1);
                    })
                    ->get();

                $extractions->each(function ($extraction) use ($reports) {
                    $reports->add($extraction);
                });
            }
        }
        return view('approvals.approved')->with(compact('reports'));
    }

    public function approvalList()
    {
        $users = User::with(['reports', 'remainings'])->get();
        $report_categories = ReportCategory::all();
        // dd($report_categories);

        return view('approvals.list')->with(
            compact('users', 'report_categories')
        );
    }

    public function approval(Report $report)
    {
        if (
            !empty(
                Auth::user()
                    ->approvals->where('approval_id', '=', 1)
                    ->first()
            )
        ) {
            $report->approval1 = 1;
        }
        // FIXME:2権限、3権限を持つuserがいたら誤作動
        if (
            !empty(
                Auth::user()
                    ->approvals->where('approval_id', '=', 2)
                    ->first()
            )
        ) {
            $report->approval2 = 1;
        }

        if (
            !empty(
                Auth::user()
                    ->approvals->where('approval_id', '=', 3)
                    ->first()
            )
        ) {
            $report->approval3 = 1;
        }

        try {
            $report->save();
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }

        if (
            $report->approval1 == 1 &&
            $report->approval2 == 1 &&
            $report->approval3 == 1
        ) {
            // 残日数を更新
            # remainingsレコード更新
            $report_id = $report->report_id;
            // if ($report_id == 2 || $report_id == 3) {
            //     $report_id = 1;
            // }
            $remaining = Remaining::where('user_id', '=', $report->user_id)
                ->where('report_id', '=', $report_id)
                ->first();
            if (!empty($remaining)) {
                $new_remaining = $remaining->remaining - $report->get_days;
                $remaining->remaining = $new_remaining;
            }

            try {
                if (!empty($remaining)) {
                    $remaining->save();
                }
            } catch (\Throwable $th) {
                return back()->withErrors($th->getMessage());
            }
        }

        return view('reports.show')
            ->with(compact('report'))
            ->with('notice', '承認しました');
    }
}
