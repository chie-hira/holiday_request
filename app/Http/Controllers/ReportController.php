<?php

namespace App\Http\Controllers;

use App\Exports\MultipleExport;
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
use App\Models\FactoryCategory;
use App\Exports\ReportExport;
use App\Exports\ReportFormExport;
use App\Models\DepartmentCategory;
use App\Models\GroupCategory;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 管理者権限は設定についての権限なので、一覧に影響しない
        // 管理者権限以外の権限を取得
        $approvals = Auth::user()->approvals->where('approval_id', '!=', 1);
        // 権限に当てはまるユーザーの申請を取得
        $reports = Report::whereHas('user', function ($query) use ($approvals) {
            $query->where(function ($query) use ($approvals) {
                foreach ($approvals as $approval) {
                    if ($approval->affiliation->department_id == 1) {
                        $query->whereHas('affiliation', function ($query) use (
                            $approval
                        ) {
                            $query->orWhere(
                                'factory_id',
                                $approval->affiliation->factory_id
                            );
                        });
                    } else {
                        $query->whereHas('affiliation', function ($query) use (
                            $approval
                        ) {
                            $query->orWhere(function ($query) use ($approval) {
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
            });
        })->get();
        // 全体の閲覧権限があるときは全てのレポートを取得
        if ($approvals->contains('affiliation_id', 1)) {
            $reports = Report::all();
        }

        # 重複削除&並べ替え
        if ($reports->first()) {
            $reports = $reports
                ->unique()
                ->load([
                    'user.affiliation',
                    'report_category',
                    'sub_report_category',
                ])
                ->sortBy('report_id')
                ->sortBy('user.affiliation_id')
                ->sortBy('start_date')
                ->sortBy('report_date');
        }
        // dd($reports);

        return view('reports.index')->with(compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sub_report_categories = SubReportCategory::all();
        $reasons = ReasonCategory::all();
        $shifts = ShiftCategory::all();
        $my_remainings = Auth::user()->remainings;
        $my_reports = Auth::user()->reports;

        /** 残日数が0ではないreport_categoryを取得 */
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

        /** バースデイ休暇の取得期間外の場合は、バースデイ休暇をreport_categoriesから除く */
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
        // 二重送信防止
        $request->session()->regenerateToken();
        // リクエストログ
        Log::info('Request data:', $request->all());

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
                        'get_days' => [Rule::in(1.0)],
                    ],
                    [
                        'get_days.in' => '終日休は1日で届出してください。',
                    ]
                );
            }
            if ($request->sub_report_id == 2) {
                # 連休
                $request->validate(
                    [
                        'end_date' => 'required',
                        'get_days' => 'integer|min:2',
                    ],
                    [
                        'get_days.min' =>
                            '連休は:attributeが:min日以上で届出してください。',
                    ]
                );
            }
            if ($request->sub_report_id == 3) {
                # 半日休暇
                $request->validate(
                    [
                        'am_pm' => 'required',
                        'get_days' => [
                            'required',
                            Rule::in(0.25, 0.3125, 0.375, 0.4375, 0.5),
                        ],
                    ],
                    [
                        'get_days.in' =>
                            '半日休は2時間、2.5時間、3時間、3.5時間、4時間で届出してください。',
                        'am_pm.required' => '前半・後半を選択してください。',
                    ]
                );
            }
            if ($request->sub_report_id == 4) {
                # 時間休
                $request->validate(
                    [
                        'start_time' => 'required',
                        'end_time' => 'required',
                        'get_days' => [
                            'numeric',
                            'max:1',
                            'multiple_of:0.125',
                            Rule::notIn([1]),
                        ],
                        // 'get_days' => [
                        //     'required',
                        //     Rule::in([
                        //         0.125,
                        //         0.25,
                        //         0.375,
                        //         0.5,
                        //         0.625,
                        //         0.75,
                        //         0.825,
                        //     ]),
                        // ],
                    ],
                    [
                        'get_days.max' => '時間給は:max日未満で届出できます。',
                        'get_days.multiple_of' =>
                            '時間休は1時間単位で届出してください。',
                        'get_days.not_in' => '時間給は1日未満で届出できます。',
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
                    'get_days' => ['required', Rule::in(1.0)],
                ],
                [
                    'get_days.in' => ':attributeは1日にしてください',
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
            $request->report_id == 18 # パパ育休
        ) {
            $request->validate(
                [
                    'end_date' => 'required',
                    'get_days' => 'min:1',
                ],
                [
                    'get_days.min' =>
                        ':attributeは:min日以上で届出してください。',
                ]
            );
        }
        if (
            $request->report_id == 13 || # 遅刻
            $request->report_id == 14 # 早退
        ) {
            $request->validate(
                [
                    'start_time' => 'required',
                    'end_time' => 'required',
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
                    'get_days.in' => '遅刻・早退は10分単位で届出してください。',
                ]
            );
        }
        if ($request->report_id == 15) {
            # 外出
            $request->validate(
                [
                    'start_time' => 'required',
                    'end_time' => 'required',
                    'get_days' => [
                        'numeric',
                        'max:1',
                        'multiple_of:0.0625',
                        Rule::notIn([1]),
                        // Rule::in([
                        //     0.0625,
                        //     0.125,
                        //     0.1875,
                        //     0.25,
                        //     0.3125,
                        //     0.375,
                        //     0.4375,
                        //     0.5,
                        //     0.5625,
                        //     0.625,
                        //     0.6875,
                        //     0.75,
                        //     0.8125,
                        //     0.825,
                        //     0.9375,
                        // ]),
                    ],
                ],
                [
                    'get_days.max' => '外出は:max日未満で届出できます。',
                    'get_days.multiple_of' =>
                        '外出は30分単位で届出してください。',
                    'get_days.not_in' => '外出は1日未満で届出できます。',
                ]
            );
        }
        if ($request->reason_id == 9) {
            # 理由:その他
            $request->validate(
                [
                    'reason_detail' => 'required',
                ],
                [
                    'reason_detail.required' => '理由は必須です。',
                ]
            );
        }

        $remaining = Remaining::where('user_id', Auth::user()->id)
            ->where('report_id', $request->report_id)
            ->first();
        if (!empty($remaining->remaining)) {
            $result =
                $remaining->remaining -
                $remaining->pending_get_days -
                $request->get_days; // 残日数-申請中日数-申請日数

            if ($result < 0) {
                throw ValidationException::withMessages([
                    'get_days' => ['取得上限を超えています'],
                ]);
            }
        }

        # reportsレコード作成
        $report = new Report();
        $report->fill($request->all());

        /** 部長・工場長承認権限がある者が自身の申請を承認する */
        if (
            !empty(
                Auth::user()
                    ->approvals->where('approval_id', 2)
                    ->first()
            )
        ) {
            $report->approval1 = 1;
            $report->approval2 = 1;
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
                // 管轄内の課長・GLにメール通知
                $approvals = Auth::user()->approvals->where('approval_id', 2);

                foreach ($approvals as $approval) {
                    if ($approval->department_id == 1) {
                        // 工場単位で通知相手を抽出
                        $approvers = User::whereHas('approvals', function (
                            $query
                        ) use ($approval) {
                            $query->where(function ($query) use ($approval) {
                                $query
                                    ->where('factory_id', $approval->factory_id)
                                    ->where('approval_id', 3);
                            });
                        })->get();
                        // 承認済みをメール通知
                        if ($approvers) {
                            foreach ($approvers as $approver) {
                                $approver->Approved($report);
                            }
                        }
                    } else {
                        // 課単位で通知相手を抽出
                        $approvers = User::whereHas('approvals', function (
                            $query
                        ) use ($approval) {
                            $query->where(function ($query) use ($approval) {
                                $query
                                    ->where('factory_id', $approval->factory_id)
                                    ->where(
                                        'department_id',
                                        $approval->department_id
                                    )
                                    ->where('approval_id', 3);
                            });
                        })->get();
                        // 承認済みをメール通知
                        if ($approvers) {
                            foreach ($approvers as $approver) {
                                $approver->Approved($report);
                            }
                        }
                    }
                }
                // リダイレクト
                return redirect()
                    ->route('reports.show', $report)
                    ->with('msg', 'Approved');
            } catch (\Exception $e) {
                DB::rollBack(); # トランザクション失敗終了
                // 例外情報をログに出力
                Log::error('Exception caught: ' . $e->getMessage());
                // エラー内容をそのまま表示しない
                return back()->with('error', 'エラーが発生しました。');
            }
        }

        /** 課長・GL承認権限がある者が自身の申請を承認する */
        if (
            !empty(
                Auth::user()
                    ->approvals->where('approval_id', 3)
                    ->first()
            )
        ) {
            $report->approval2 = 1;
            try {
                $report->save();

                $approvers = User::whereHas('approvals', function ($query) use (
                    $report
                ) {
                    $query
                        ->where('factory_id', $report->user->affiliation->factory_id)
                        ->where(function ($query) use ($report) {
                            $query
                                ->orWhere('approval_id', 2)
                                ->orWhere(function ($query) use ($report) {
                                    $query
                                        ->where(
                                            'user_id',
                                            '!=',
                                            Auth::user()->id
                                        )
                                        ->where(
                                            'department_id',
                                            $report->user->department_id
                                        )
                                        ->where(
                                            'group_id',
                                            $report->user->group_id
                                        )
                                        ->where('approval_id', 3);
                                });
                        });
                })->get();
                if ($approvers) {
                    foreach ($approvers as $approver) {
                        $approver->storeReport($report);
                    }
                }

                return redirect(route('reports.show', $report))->with(
                    'notice',
                    'StoreReport'
                );
            } catch (\Throwable $th) {
                // 例外情報をログに出力
                Log::error('Exception caught: ' . $th->getMessage());
                // エラー内容をそのまま表示しない
                return back()->with('error', 'エラーが発生しました。');
            }
        }

        /** 一般的な届出 */
        try {
            $report->save();

            // TODO:権限の組み合わせにルールをつける。以下に無い組み合わせが発生する可能性あり
            $approvers = User::whereHas('approvals', function ($query) use (
                $report
            ) {
                $query
                    ->where('factory_id', $report->user->factory_id)
                    ->where(function ($query) use ($report) {
                        $query
                            ->orWhere(function ($query) use ($report) {
                                $query
                                    ->where('approval_id', 2)
                                    ->where(function ($query) use ($report) {
                                        $query
                                            ->orWhere('department_id', 1)
                                            // ->orWhere(function ($query) use (
                                            //     $report
                                            // ) {
                                            //     $query
                                            //         ->where(
                                            //             'department_id',
                                            //             $report->user
                                            //                 ->department_id
                                            //         )
                                            //         ->where(function (
                                            //             $query
                                            //         ) use ($report) {
                                            //             $query
                                            //                 ->orWhere(
                                            //                     'group_id',
                                            //                     1
                                            //                 )
                                            //                 ->orWhere(
                                            //                     'group_id',
                                            //                     $report->user
                                            //                         ->group_id
                                            //                 );
                                            //         });
                                            // });
                                            ->orWhere(
                                                'department_id',
                                                $report->user->department_id
                                            );
                                    });
                            })
                            ->orWhere(function ($query) use ($report) {
                                $query
                                    ->where('approval_id', 3)
                                    ->where(
                                        'department_id',
                                        $report->user->department_id
                                    )
                                    ->where(
                                        'group_id',
                                        $report->user->group_id
                                    );
                                // ->where(function ($query) use ($report) {
                                //     $query
                                //         ->orWhere('department_id', 1)
                                //         ->orWhere(
                                //             'department_id',
                                //             $report->user->department_id
                                //         );
                                // });
                            });
                    });
            })->get();

            return redirect(route('reports.show', $report))->with(
                'notice',
                'StoreReport'
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
        $sub_report_categories = SubReportCategory::all();
        $reasons = ReasonCategory::all();
        $shifts = ShiftCategory::all();
        $my_remainings = Auth::user()->remainings;
        $my_reports = Auth::user()->reports->where('id', '!=', $report->id);

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

        return view('reports.edit')->with(
            compact(
                'report',
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
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReportRequest  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReportRequest $request, Report $report)
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
                        'get_days' => [Rule::in(1.0)],
                    ],
                    [
                        'get_days.in' => '終日休は1日で届出してください。',
                    ]
                );
            }
            if ($request->sub_report_id == 2) {
                # 連休
                $request->validate(
                    [
                        'end_date' => 'required',
                        'get_days' => 'integer|min:2',
                    ],
                    [
                        'get_days.min' =>
                            '連休は:attributeが:min日以上で届出してください。',
                    ]
                );
            }
            if ($request->sub_report_id == 3) {
                # 半日休暇
                $request->validate(
                    [
                        'am_pm' => 'required',
                        'get_days' => [
                            'required',
                            Rule::in(0.25, 0.3125, 0.375, 0.4375, 0.5),
                        ],
                    ],
                    [
                        'get_days.in' =>
                            '半日休は2時間、2.5時間、3時間、3.5時間、4時間で届出してください。',
                        'am_pm.required' => '前半・後半を選択してください。',
                    ]
                );
            }
            if ($request->sub_report_id == 4) {
                # 時間休
                $request->validate(
                    [
                        'start_time' => 'required',
                        'end_time' => 'required',
                        'get_days' => [
                            'numeric',
                            'max:1',
                            'multiple_of:0.125',
                            Rule::notIn([1]),
                        ],
                        // 'get_days' => [
                        //     'required',
                        //     Rule::in([
                        //         0.125,
                        //         0.25,
                        //         0.375,
                        //         0.5,
                        //         0.625,
                        //         0.75,
                        //         0.825,
                        //     ]),
                        // ],
                    ],
                    [
                        'get_days.max' => '時間給は:max日未満で届出できます。',
                        'get_days.multiple_of' =>
                            '時間休は1時間単位で届出してください。',
                        'get_days.not_in' => '時間給は1日未満で届出できます。',
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
                    'get_days' => ['required', Rule::in(1.0)],
                ],
                [
                    'get_days.in' => ':attributeは1日にしてください',
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
            $request->report_id == 18 # パパ育休
        ) {
            $request->validate(
                [
                    'end_date' => 'required',
                    'get_days' => 'min:1',
                ],
                [
                    'get_days.min' =>
                        ':attributeは:min日以上で届出してください。',
                ]
            );
        }
        if (
            $request->report_id == 13 || # 遅刻
            $request->report_id == 14 # 早退
        ) {
            $request->validate(
                [
                    'start_time' => 'required',
                    'end_time' => 'required',
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
                    'get_days.in' => '遅刻・早退は10分単位で届出してください。',
                ]
            );
        }
        if ($request->report_id == 15) {
            # 外出
            $request->validate(
                [
                    'start_time' => 'required',
                    'end_time' => 'required',
                    'get_days' => [
                        'numeric',
                        'max:1',
                        'multiple_of:0.0625',
                        Rule::notIn([1]),
                        // Rule::in([
                        //     0.0625,
                        //     0.125,
                        //     0.1875,
                        //     0.25,
                        //     0.3125,
                        //     0.375,
                        //     0.4375,
                        //     0.5,
                        //     0.5625,
                        //     0.625,
                        //     0.6875,
                        //     0.75,
                        //     0.8125,
                        //     0.825,
                        //     0.9375,
                        // ]),
                    ],
                ],
                [
                    'get_days.max' => '外出は:max日未満で届出できます。',
                    'get_days.multiple_of' =>
                        '外出は30分単位で届出してください。',
                    'get_days.not_in' => '外出は1日未満で届出できます。',
                ]
            );
        }
        if ($request->reason_id == 9) {
            # 理由:その他
            $request->validate(
                [
                    'reason_detail' => 'required',
                ],
                [
                    'reason_detail.required' => '理由は必須です。',
                ]
            );
        }

        $remaining = Remaining::where('user_id', Auth::user()->id)
            ->where('report_id', $request->report_id)
            ->first();
        if (!empty($remaining->remaining)) {
            $result =
                $remaining->remaining -
                $remaining->pending_get_days -
                $request->get_days; // 残日数-申請中日数-申請日数

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

        /** 課長・GL承認権限がある者が自身の申請を承認する */
        if (
            !empty(
                Auth::user()
                    ->approvals->where('approval_id', 3)
                    ->first()
            )
        ) {
            $report->approval2 = 1;
            try {
                $report->save();

                $approvers = User::whereHas('approvals', function ($query) use (
                    $report
                ) {
                    $query
                        ->where('factory_id', $report->user->factory_id)
                        ->where(function ($query) use ($report) {
                            $query
                                ->orWhere('approval_id', 2)
                                ->orWhere(function ($query) use ($report) {
                                    $query
                                        ->where(
                                            'user_id',
                                            '!=',
                                            Auth::user()->id
                                        )
                                        ->where(
                                            'department_id',
                                            $report->user->department_id
                                        )
                                        ->where(
                                            'group_id',
                                            $report->user->group_id
                                        )
                                        ->where('approval_id', 3);
                                });
                        });
                })->get();
                if ($approvers) {
                    foreach ($approvers as $approver) {
                        $approver->storeReport($report);
                    }
                }

                return redirect(route('reports.show', $report))->with(
                    'notice',
                    'UpdateReport'
                );
            } catch (\Throwable $th) {
                // 例外情報をログに出力
                Log::error('Exception caught: ' . $th->getMessage());
                // エラー内容をそのまま表示しない
                return back()->with('error', 'エラーが発生しました。');
            }
        }

        /** 一般的な届出 */
        try {
            $report->save();

            // TODO:権限の組み合わせにルールをつける。以下に無い組み合わせが発生する可能性あり
            $approvers = User::whereHas('approvals', function ($query) use (
                $report
            ) {
                $query
                    ->where('factory_id', $report->user->factory_id)
                    ->where(function ($query) use ($report) {
                        $query
                            ->orWhere(function ($query) use ($report) {
                                $query
                                    ->where('approval_id', 2)
                                    ->where(function ($query) use ($report) {
                                        $query
                                            ->orWhere('department_id', 1)
                                            // ->orWhere(function ($query) use (
                                            //     $report
                                            // ) {
                                            //     $query
                                            //         ->where(
                                            //             'department_id',
                                            //             $report->user
                                            //                 ->department_id
                                            //         )
                                            //         ->where(function (
                                            //             $query
                                            //         ) use ($report) {
                                            //             $query
                                            //                 ->orWhere(
                                            //                     'group_id',
                                            //                     1
                                            //                 )
                                            //                 ->orWhere(
                                            //                     'group_id',
                                            //                     $report->user
                                            //                         ->group_id
                                            //                 );
                                            //         });
                                            // });
                                            ->orWhere(
                                                'department_id',
                                                $report->user->department_id
                                            );
                                    });
                            })
                            ->orWhere(function ($query) use ($report) {
                                $query
                                    ->where('approval_id', 3)
                                    ->where(
                                        'department_id',
                                        $report->user->department_id
                                    )
                                    ->where(
                                        'group_id',
                                        $report->user->group_id
                                    );
                                // ->where(function ($query) use ($report) {
                                //     $query
                                //         ->orWhere('department_id', 1)
                                //         ->orWhere(
                                //             'department_id',
                                //             $report->user->department_id
                                //         );
                                // });
                            });
                    });
            })->get();

            return redirect(route('reports.show', $report))->with(
                'notice',
                'UpdateReport'
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
        $report->cancel = 1; // キャンセルon

        // 一般の通知対象を用意
        // 申請者のapprover1,2にメール通知
        $approvers = User::whereHas('approvals', function ($query) use (
            $report
        ) {
            $query
                ->where('factory_id', $report->user->factory_id)
                ->where(function ($query) use ($report) {
                    $query
                        ->orWhere(function ($query) use ($report) {
                            $query
                                ->where('approval_id', 2)
                                ->where(function ($query) use ($report) {
                                    $query
                                        ->orWhere('department_id', 1)
                                        ->orWhere(
                                            'department_id',
                                            $report->user->department_id
                                        );
                                });
                        })
                        ->orWhere(function ($query) use ($report) {
                            $query
                                ->where('approval_id', 3)
                                ->where(
                                    'department_id',
                                    $report->user->department_id
                                )
                                ->where('group_id', $report->user->group_id);
                        });
                });
        })->get();

        /** 部長・工場長承認権限がある者が自身の申請を取消す場合このスコープには入ってこない */
        /** approved_cancelメソッドで取消処理 */

        /** 課長・GL承認権限がある者が自身の申請を取消する */
        if (
            !empty(
                Auth::user()
                    ->approvals->where('factory_id', $report->user->factory_id)
                    ->where('department_id', $report->user->department_id)
                    ->where('approval_id', 3)
                    ->first()
            )
        ) {
            $report->approval2 = 0;

            // 部長・工場長だけ通知対象
            $approvers = User::whereHas('approvals', function ($query) use (
                $report
            ) {
                $query
                    ->where('approval_id', 2)
                    ->where('factory_id', $report->user->factory_id)
                    ->where(function ($query) use ($report) {
                        $query
                            ->orWhere('department_id', 1)
                            ->orWhere(
                                'department_id',
                                $report->user->department_id
                            );
                    });
            })->get();
        }
        $report->save();

        // 誰も承認していない場合
        if (
            $report->cancel == 1 &&
            $report->approval1 == 0 &&
            $report->approval2 == 0
        ) {
            try {
                $report->delete();

                if ($approvers) {
                    foreach ($approvers as $approver) {
                        $approver->destroyReport($report);
                    }
                }

                return redirect()
                    ->route('reports.my_index')
                    ->with('notice', 'DestroyReport');
            } catch (\Throwable $th) {
                Log::error('Exception caught: ' . $th->getMessage());
                return back()->with('error', 'エラーが発生しました。');
            }
        } else {
            // 承認がある場合
            // 上長が承認している場合
            if ($report->approval1 == 1 && $report->approval2 == 0) {
                // 上長に通知
                $approvers = User::whereHas('approvals', function ($query) use (
                    $report
                ) {
                    $query
                        ->where('approval_id', 2)
                        ->where('factory_id', $report->user->factory_id)
                        ->where(function ($query) use ($report) {
                            $query
                                ->orWhere('department_id', 1)
                                ->orWhere(
                                    'department_id',
                                    $report->user->department_id
                                );
                        });
                })->get();
            }
            // 係長が承認している場合
            if ($report->approval1 == 0 && $report->approval2 == 1) {
                // 係長に通知
                $approvers = User::whereHas('approvals', function ($query) use (
                    $report
                ) {
                    $query
                        ->where('approval_id', 3)
                        ->where('factory_id', $report->user->factory_id)
                        ->where('department_id', $report->user->department_id);
                })->get();
            }
            // 承認したapproversに取消確認の通知メール送信
            if ($approvers) {
                foreach ($approvers as $approver) {
                    $approver->cancelReport($report);
                }
            }
            return redirect()
                ->route('reports.my_index')
                ->with('notice', 'CancelReport');
        }
    }

    public function myIndex()
    {
        $reports = Auth::user()
            ->reports->load(['report_category', 'sub_report_category'])
            ->sortBy('start_date')
            ->sortBy('report_date');
        return view('reports.my_index')->with(compact('reports'));
    }

    /** 承認済み届出の取消申請 */
    public function approvedCancel(Report $report)
    {
        $report->cancel = 1; # キャンセルon
        $approvers = User::whereHas('approvals', function ($query) use (
            $report
        ) {
            $query
                ->where('factory_id', $report->user->factory_id)
                ->where(function ($query) use ($report) {
                    $query
                        ->orWhere(function ($query) use ($report) {
                            $query
                                ->where('approval_id', 2)
                                ->where(function ($query) use ($report) {
                                    $query
                                        ->orWhere('department_id', 1)
                                        ->orWhere(
                                            'department_id',
                                            $report->user->department_id
                                        );
                                });
                        })
                        ->orWhere(function ($query) use ($report) {
                            $query
                                ->where('approval_id', 3)
                                ->where(
                                    'department_id',
                                    $report->user->department_id
                                )
                                ->where('group_id', $report->user->group_id);
                        });
                });
        })->get();

        /** 部長・工場長承認権限をもつ者が自身の申請を取消す場合 */
        if (
            !empty(
                Auth::user()
                    ->approvals->where('approval_id', 2)
                    ->where('factory_id', $report->user->factory_id)
                    ->first()
            )
        ) {
            $report->approval1 = 0;
            $report->approval2 = 0;
            $report->save();

            $gl_approvers = User::whereHas('approvals', function ($query) {
                $query->where('approval_id', 3);
            })
                ->where('factory_id', Auth::user()->factory_id)
                ->get();

            // if ($report->approval1 == 0 && $report->approval2 == 0) {
            $remaining = Remaining::all()
                ->where('report_id', $report->report_id)
                ->where('user_id', $report->user_id)
                ->first();

            if (empty($remaining)) {
                try {
                    $report->delete();

                    // 部下に取消通知メール送信
                    if ($gl_approvers) {
                        foreach ($gl_approvers as $approver) {
                            $approver->destroyReport($report);
                        }
                    }

                    return redirect()
                        ->route('reports.my_index')
                        ->with('notice', 'DestroyReport');
                } catch (\Throwable $th) {
                    Log::error('Exception caught: ' . $th->getMessage());
                    return back()->with('error', 'エラーが発生しました。');
                }
            } else {
                /** 残日数加算&申請取消 */
                $remaining->remaining += $report->get_days;
                DB::beginTransaction(); # トランザクション開始
                try {
                    $remaining->save();
                    $report->delete();

                    DB::commit(); # トランザクション成功終了
                    // 部下に取消通知メール送信
                    if ($gl_approvers) {
                        foreach ($gl_approvers as $approver) {
                            $approver->destroyReport($report);
                        }
                    }

                    return redirect()
                        ->route('reports.my_index')
                        ->with('notice', 'DestroyReport');
                } catch (\Throwable $th) {
                    DB::rollBack(); # トランザクション失敗終了
                    Log::error('Exception caught: ' . $th->getMessage());
                    return back()->with('error', 'エラーが発生しました。');
                }
            }
            // }
        }

        /** 課長・GL承認権限をもつ者が自身の申請を取消す場合 */
        if (
            !empty(
                Auth::user()
                    ->approvals->where('factory_id', $report->user->factory_id)
                    ->where('department_id', $report->user->department_id)
                    ->where('approval_id', 3)
                    ->first()
            )
        ) {
            $report->approval2 = 0; # 取消確認済み
            // $report->save();
            $approvers = User::whereHas('approvals', function ($query) use (
                $report
            ) {
                $query
                    ->where('factory_id', $report->user->factory_id)
                    ->where('approval_id', 2);
            })->get();
        }

        /** 通常のキャンセル */
        try {
            $report->save();
            if ($approvers) {
                foreach ($approvers as $approver) {
                    $approver->cancelReport($report); // 取消申請をapproverにメール通知
                }
            }
            return redirect()
                ->route('reports.my_index')
                ->with('notice', 'CancelReport');
        } catch (\Throwable $th) {
            Log::error('Exception caught: ' . $th->getMessage());
            return back()->with('error', 'エラーが発生しました。');
        }
    }

    public function getAndRemaining()
    {
        $approvals = Auth::user()->approvals->where('approval_id', '!=', 1);
        $users = User::where(function ($query) use ($approvals) {
            foreach ($approvals as $approval) {
                if ($approval->affiliation->department_id == 1) {
                    $query->orWhere(function ($query) use ($approval) {
                        $query->whereHas('affiliation', function ($query) use (
                            $approval
                        ) {
                            $query->where('factory_id', $approval->factory_id);
                        });
                    });
                } elseif (
                    $approval->department_id != 1 &&
                    $approval->affiliation->group_id == 1
                ) {
                    $query->orWhere(function ($query) use ($approval) {
                        $query->whereHas('affiliation', function ($query) use (
                            $approval
                        ) {
                            $query
                                ->where('factory_id', $approval->factory_id)
                                ->where(
                                    'department_id',
                                    $approval->department_id
                                );
                        });
                    });
                } elseif (
                    $approval->department_id != 1 &&
                    $approval->affiliation->group_id != 1
                ) {
                    $query->orWhere(function ($query) use ($approval) {
                        $query->whereHas('affiliation', function ($query) use (
                            $approval
                        ) {
                            $query
                                ->where('factory_id', $approval->factory_id)
                                ->where(
                                    'department_id',
                                    $approval->department_id
                                )
                                ->where('group_id', $approval->group_id);
                        });
                    });
                }
            }
        })->get();

        # 重複削除&並べ替え
        if ($users->first()) {
            $users = $users
                ->unique()
                ->load(['affiliation', 'reports', 'remainings'])
                ->sortBy('employee')
                ->sortBy('affiliation_id');
        }

        $report_categories = ReportCategory::all();

        return view('reports.get_and_remaining')->with(
            compact('users', 'report_categories')
        );
    }

    # 承認
    public function approval(Report $report)
    {
        $approvals = Auth::user()->approvals->whereIn('approval_id', [2, 3]);
        $gl_approval = Approval::where('approval_id', 3)
            ->where('factory_id', $report->user->factory_id)
            ->where('department_id', $report->user->department_id)
            ->where(function ($query) use ($report) {
                $query
                    ->orWhere('group_id', $report->user->group_id)
                    ->orWhere('group_id', 1);
            })
            ->get();

        foreach ($approvals as $approval) {
            // TODO:GLがいないときは部長・工場長だけ承認を追加
            if (
                $approval->approval_id == 2 &&
                $approval->factory_id == $report->user->factory_id &&
                ($approval->department_id == $report->user->department_id ||
                    $approval->department_id == 1)
            ) {
                $report->approval1 = 1;
                if (empty($gl_approval->first())) {
                    $report->approval2 = 1;
                }
            } elseif (
                $approval->approval_id == 3 &&
                $approval->factory_id == $report->user->factory_id &&
                $approval->department_id == $report->user->department_id &&
                ($approval->group_id == $report->user->group_id ||
                    $approval->group_id == 1)
            ) {
                $report->approval2 = 1;
            }
        }

        if ($report->approval1 == 1 && $report->approval2 == 1) {
            $report->approved = 1; # 承認
            DB::beginTransaction(); # トランザクション開始
            try {
                $report->save(); # 承認を保存
                $remaining = Remaining::where('user_id', $report->user_id)
                    ->where('report_id', $report->report_id)
                    ->first();
                if (!empty($remaining)) {
                    $new_remaining = $remaining->remaining - $report->get_days;
                    $remaining->remaining = $new_remaining;
                    $remaining->save(); # 残日数を保存
                }
                DB::commit(); # トランザクション成功終了
                $user = $report->user;
                $user->approved($report); # 届出作成者に承認を通知
                return redirect()
                    ->route('reports.show', $report)
                    ->with('msg', 'Approved');
            } catch (\Exception $e) {
                DB::rollBack(); # トランザクション失敗終了
                Log::error('Exception caught: ' . $e->getMessage());
                return back()->with('error', 'エラーが発生しました。');
            }
        } else {
            try {
                $report->save(); # 承認を保存
                return redirect()
                    ->route('reports.show', $report)
                    ->with('msg', 'Approved');
            } catch (\Throwable $th) {
                Log::error('Exception caught: ' . $th->getMessage());
                return back()->with('error', 'エラーが発生しました。');
            }
        }
    }

    # 承認取消
    public function approvalCancel(Report $report)
    {
        $approvals = Auth::user()->approvals->whereIn('approval_id', [2, 3]);
        $gl_approval = Approval::where('approval_id', 3)
            ->where('factory_id', $report->user->factory_id)
            ->where('department_id', $report->user->department_id)
            ->where(function ($query) use ($report) {
                $query
                    ->orWhere('group_id', $report->user->group_id)
                    ->orWhere('group_id', 1);
            })
            ->get();

        foreach ($approvals as $approval) {
            if (
                $approval->approval_id == 2 &&
                $approval->factory_id == $report->user->factory_id &&
                ($approval->department_id == $report->user->department_id ||
                    $approval->department_id == 1)
            ) {
                $report->approval1 = 0;
                if (empty($gl_approval->first())) {
                    $report->approval2 = 0;
                }
            } elseif (
                $approval->approval_id == 3 &&
                $approval->factory_id == $report->user->factory_id &&
                $approval->department_id == $report->user->department_id &&
                ($approval->group_id == $report->user->group_id ||
                    $approval->group_id == 1)
            ) {
                $report->approval2 = 0;
            }
        }
        $report->save();

        /** すべて確認された場合、remainingを更新 */
        if (
            $report->cancel == 1 &&
            $report->approval1 == 0 &&
            $report->approval2 == 0
        ) {
            $report_user = $report->user; // 申請者

            if ($report->approved == 0) {
                try {
                    $report->delete(); // 申請を削除
                    $report_user->destroyReport($report); // 申請者に取消メール通知
                    return redirect()
                        ->route('reports.index')
                        ->with('notice', 'DestroyReport');
                } catch (\Throwable $th) {
                    Log::error('Exception caught: ' . $th->getMessage());
                    return back()->with('error', 'エラーが発生しました。');
                }
            } elseif ($report->approved == 1) {
                $remaining = Remaining::where('report_id', $report->report_id)
                    ->where('user_id', $report->user_id)
                    ->first();
                if (empty($remaining)) {
                    # remainingがない場合
                    try {
                        $report->delete();
                        $report_user->destroyReport($report); // 申請者に取消メール通知
                        return redirect()
                            ->route('reports.index')
                            ->with('notice', 'DestroyReport');
                    } catch (\Throwable $th) {
                        Log::error('Exception caught: ' . $th->getMessage());
                        return back()->with('error', 'エラーが発生しました。');
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
                        // approverに申請取消を通知
                        $report_user->destroyReport($report); // 申請者に取消メール通知
                        return redirect()
                            ->route('reports.index')
                            ->with('notice', 'DestroyReport');
                    } catch (\Throwable $th) {
                        DB::rollBack(); # トランザクション失敗終了
                        Log::error('Exception caught: ' . $th->getMessage());
                        return back()->with('error', 'エラーが発生しました。');
                    }
                }
            }
        } else {
            try {
                $report->save(); # 取消確認を保存
                // 取消確認しました
                return redirect()
                    ->route('reports.show', $report)
                    ->with('msg', 'CheckedReport');
            } catch (\Throwable $th) {
                Log::error('Exception caught: ' . $th->getMessage());
                return back()->with('error', 'エラーが発生しました。');
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

        $approvals = Auth::user()->approvals->whereIn('approval_id', [2, 3]);
        if ($approvals->first()) {
            $pending_reports = Report::whereHas('user', function ($query) use (
                $approvals
            ) {
                $query->where(function ($query) use ($approvals) {
                    // FIXME:どれにもあてはまらなかったらどうなる？0カウントで問題ない？
                    foreach ($approvals as $approval) {
                        if (
                            $approval->approval_id == 2 &&
                            $approval->affiliation->department_id == 1
                        ) {
                            $query->orWhere(function ($query) use ($approval) {
                                $query
                                    ->whereHas('affiliation', function (
                                        $query
                                    ) use ($approval) {
                                        $query->where(
                                            'factory_id',
                                            $approval->factory_id
                                        );
                                    })
                                    ->where('cancel', 0)
                                    ->where('approval1', 0);
                            });
                        }
                        if (
                            $approval->approval_id == 2 &&
                            $approval->affiliation->department_id != 1
                        ) {
                            $query->orWhere(function ($query) use ($approval) {
                                $query
                                    ->whereHas('affiliation', function (
                                        $query
                                    ) use ($approval) {
                                        $query
                                            ->where(
                                                'factory_id',
                                                $approval->affiliation
                                                    ->factory_id
                                            )
                                            ->where(
                                                'department_id',
                                                $approval->affiliation
                                                    ->department_id
                                            );
                                    })
                                    ->where('cancel', 0)
                                    ->where('approval1', 0);
                            });
                        }
                        if (
                            $approval->approval_id == 3 &&
                            $approval->affiliation->department_id == 1
                        ) {
                            $query->orWhere(function ($query) use ($approval) {
                                $query
                                    ->whereHas('affiliation', function (
                                        $query
                                    ) use ($approval) {
                                        $query->where(
                                            'factory_id',
                                            $approval->affiliation->factory_id
                                        );
                                    })
                                    ->where('cancel', 0)
                                    ->where('approval2', 0);
                            });
                        }
                        if (
                            $approval->approval_id == 3 &&
                            $approval->affiliation->department_id != 1
                        ) {
                            $query->orWhere(function ($query) use ($approval) {
                                $query
                                    ->whereHas('affiliation', function (
                                        $query
                                    ) use ($approval) {
                                        $query
                                            ->where(
                                                'factory_id',
                                                $approval->affiliation
                                                    ->factory_id
                                            )
                                            ->where(
                                                'department_id',
                                                $approval->affiliation
                                                    ->department_id
                                            );
                                    })
                                    ->where('cancel', 0)
                                    ->where('approval2', 0);
                            });
                        }
                    }
                });
            })->get();

            // dd($pending_reports);
            $cancel_reports = Report::whereHas('user', function ($query) use (
                $approvals
            ) {
                $query->where(function ($query) use ($approvals) {
                    foreach ($approvals as $approval) {
                        if (
                            $approval->approval_id == 2 &&
                            $approval->affiliation->department_id == 1
                        ) {
                            $query->orWhere(function ($query) use ($approval) {
                                $query
                                    ->whereHas('affiliation', function (
                                        $query
                                    ) use ($approval) {
                                        $query->where(
                                            'factory_id',
                                            $approval->affiliation->factory_id
                                        );
                                    })
                                    ->where('cancel', 1)
                                    ->where('approval1', 1);
                            });
                        }
                        if (
                            $approval->approval_id == 2 &&
                            $approval->affiliation->department_id != 1
                        ) {
                            $query->orWhere(function ($query) use ($approval) {
                                $query
                                    ->whereHas('affiliation', function (
                                        $query
                                    ) use ($approval) {
                                        $query
                                            ->where(
                                                'factory_id',
                                                $approval->affiliation
                                                    ->factory_id
                                            )
                                            ->where(
                                                'department_id',
                                                $approval->affiliation
                                                    ->department_id
                                            );
                                    })
                                    ->where('cancel', 1)
                                    ->where('approval1', 1);
                            });
                        }
                        if (
                            $approval->approval_id == 3 &&
                            $approval->affiliation->department_id == 1
                        ) {
                            $query->orWhere(function ($query) use ($approval) {
                                $query
                                    ->whereHas('affiliation', function (
                                        $query
                                    ) use ($approval) {
                                        $query->where(
                                            'factory_id',
                                            $approval->affiliation->factory_id
                                        );
                                    })
                                    ->where('cancel', 1)
                                    ->where('approval2', 1);
                            });
                        }
                        if (
                            $approval->approval_id == 3 &&
                            $approval->affiliation->department_id != 1
                        ) {
                            $query->orWhere(function ($query) use ($approval) {
                                $query
                                    ->whereHas('affiliation', function (
                                        $query
                                    ) use ($approval) {
                                        $query
                                            ->where(
                                                'factory_id',
                                                $approval->affiliation
                                                    ->factory_id
                                            )
                                            ->where(
                                                'department_id',
                                                $approval->affiliation
                                                    ->department_id
                                            );
                                    })
                                    ->where('cancel', 1)
                                    ->where('approval2', 1);
                            });
                        }
                    }
                });
            })->get();

            $pending_reports = $pending_reports->unique(); # 重複削除
            # 承認待ち件数count
            if (!empty($pending_reports)) {
                $pending = count($pending_reports);
            } else {
                $pending = 0;
            }

            $cancel_reports = $cancel_reports->unique(); # 重複削除
            # 承認済みの取消確認件数count
            if (!empty($cancel_reports)) {
                $approved = count($cancel_reports);
            } else {
                $approved = 0;
            }
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

    public function export_form()
    {
        // 管理者権限は設定についての権限なので、一覧に影響しない
        $approvals = Auth::user()->approvals->where('approval_id', '!=', 1);
        $reports = Report::whereHas('user', function ($query) use ($approvals) {
            $query->where(function ($query) use ($approvals) {
                foreach ($approvals as $approval) {
                    if ($approval->department_id == 1) {
                        $query->orWhere(function ($query) use ($approval) {
                            $query
                                ->whereHas('affiliation', function (
                                    $query
                                ) use ($approval) {
                                    $query->where(
                                        'factory_id',
                                        $approval->affiliation->factory_id
                                    );
                                })
                                ->where('approved', 1)
                                ->where('cancel', 0);
                        });
                    } elseif (
                        $approval->department_id != 1 &&
                        $approval->affiliation->group_id == 1
                    ) {
                        $query->orWhere(function ($query) use ($approval) {
                            $query
                                ->whereHas('affiliation', function (
                                    $query
                                ) use ($approval) {
                                    $query
                                        ->where(
                                            'factory_id',
                                            $approval->affiliation->factory_id
                                        )
                                        ->where(
                                            'department_id',
                                            $approval->affiliation
                                                ->department_id
                                        );
                                })
                                ->where('approved', 1)
                                ->where('cancel', 0);
                        });
                    } elseif (
                        $approval->department_id != 1 &&
                        $approval->affiliation->group_id != 1
                    ) {
                        $query->orWhere(function ($query) use ($approval) {
                            $query
                                ->whereHas('affiliation', function (
                                    $query
                                ) use ($approval) {
                                    $query
                                        ->where(
                                            'factory_id',
                                            $approval->affiliation->factory_id
                                        )
                                        ->where(
                                            'department_id',
                                            $approval->affiliation
                                                ->department_id
                                        )
                                        ->where(
                                            'group_id',
                                            $approval->affiliation->group_id
                                        );
                                })
                                ->where('approved', 1)
                                ->where('cancel', 0);
                        });
                    }
                }
            });
        })->get();

        # 重複削除&並べ替え
        if ($reports->first()) {
            $reports = $reports
                ->unique()
                ->load([
                    'user',
                    'user.affiliation',
                    'report_category',
                    'reason_category',
                ])
                ->sortBy('user.affiliation_id')
                ->sortBy('report_date');
        }
        $factories = FactoryCategory::all();
        $departments = DepartmentCategory::all();
        $report_categories = ReportCategory::all();
        $reason_categories = ReasonCategory::all();
        $users = User::all('id', 'employee');

        return view('reports.export_form')->with(
            compact(
                'reports',
                'factories',
                'departments',
                'report_categories',
                'reason_categories',
                'users'
            )
        );
    }

    public function export(Request $request)
    {
        // 二重送信防止
        // $request->session()->regenerateToken();
        Log::info('Request data:', $request->all());

        // 管理者権限は設定についての権限なので、一覧に影響しない
        $approvals = Auth::user()->approvals->where('approval_id', '!=', 1);
        $reports = Report::whereHas('user', function ($query) use ($approvals) {
            $query->where(function ($query) use ($approvals) {
                foreach ($approvals as $approval) {
                    if ($approval->affiliation->department_id == 1) {
                        $query->orWhere(function ($query) use ($approval) {
                            $query
                                ->whereHas('affiliation', function (
                                    $query
                                ) use ($approval) {
                                    $query->where(
                                        'factory_id',
                                        $approval->affiliation->factory_id
                                    );
                                })
                                ->where('approved', 1)
                                ->where('cancel', 0);
                        });
                    } elseif (
                        $approval->department_id != 1 &&
                        $approval->affiliation->group_id == 1
                    ) {
                        $query->orWhere(function ($query) use ($approval) {
                            $query
                                ->whereHas('affiliation', function (
                                    $query
                                ) use ($approval) {
                                    $query
                                        ->where(
                                            'factory_id',
                                            $approval->affiliation->factory_id
                                        )
                                        ->where(
                                            'department_id',
                                            $approval->affiliation
                                                ->department_id
                                        );
                                })
                                ->where('approved', 1)
                                ->where('cancel', 0);
                        });
                    } elseif (
                        $approval->department_id != 1 &&
                        $approval->affiliation->group_id != 1
                    ) {
                        $query->orWhere(function ($query) use ($approval) {
                            $query
                                ->whereHas('affiliation', function (
                                    $query
                                ) use ($approval) {
                                    $query
                                        ->where(
                                            'factory_id',
                                            $approval->affiliation->factory_id
                                        )
                                        ->where(
                                            'department_id',
                                            $approval->affiliation
                                                ->department_id
                                        )
                                        ->where(
                                            'group_id',
                                            $approval->affiliation->group_id
                                        );
                                })
                                ->where('approved', 1)
                                ->where('cancel', 0);
                        });
                    }
                }
            });
        })->get();

        # 重複削除&並べ替え
        if ($reports->first()) {
            $reports = $reports
                ->unique()
                ->load([
                    'user',
                    'user.affiliation',
                    'report_category',
                    'reason_category',
                ])
                ->sortBy('user.affiliation_id')
                ->sortBy('report_date');
        }

        /** 設定条件で絞り込む
         * factory_id 工場
         * department_id 課
         * report_id 休暇種類
         * reason_id 理由
         * month 月
         */
        $factory_id = $request->factory_id;
        $department_id = $request->department_id;
        $report_id = $request->report_category_id;
        $reason_id = $request->reason_category_id;
        $month = $request->get_month;

        # monthから月初め日、月終わり日を定義
        if ($month) {
            $carbon = new Carbon($month);
            $start_date = $carbon->format('Y-m-d');
            $end_date = $carbon
                ->addMonth()
                ->subDay()
                ->format('Y-m-d');
        }

        /** 条件に従って帳票出力するreportを取得 */
        if (
            $factory_id == null &&
            $department_id == null &&
            $report_id == null &&
            $reason_id == null &&
            $month == null
        ) {
            # 全て出力
            $reports = $reports->where('approved', 1)->where('cancel', 0);
        } elseif (
            $factory_id != null &&
            $department_id == null &&
            $report_id == null &&
            $reason_id == null &&
            $month == null
        ) {
            # 所属1を指定
            $reports = $reports
                ->filter(function ($item) use ($factory_id) {
                    return $item->user->affiliation->factory_id == $factory_id;
                })
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id == null &&
            $department_id != null &&
            $report_id == null &&
            $reason_id == null &&
            $month == null
        ) {
            # 所属2を指定
            $reports = $reports
                ->filter(function ($item) use ($department_id) {
                    return $item->user->affiliation->department_id == $department_id;
                })
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id == null &&
            $department_id == null &&
            $report_id != null &&
            $reason_id == null &&
            $month == null
        ) {
            # 休暇種類を指定
            $reports = $reports
                ->where('report_id', $report_id)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id == null &&
            $department_id == null &&
            $report_id == null &&
            $reason_id != null &&
            $month == null
        ) {
            # 理由を指定
            $reports = $reports
                ->where('reason_id', $reason_id)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id == null &&
            $department_id == null &&
            $report_id == null &&
            $reason_id == null &&
            $month != null
        ) {
            # 月を指定
            $reports = $reports
                ->where('start_date', '>=', $start_date)
                ->where('start_date', '<=', $end_date)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id != null &&
            $department_id != null &&
            $report_id == null &&
            $reason_id == null &&
            $month == null
        ) {
            # 所属を指定
            $reports = $reports
                ->filter(function ($item) use ($factory_id) {
                    return $item->user->affiliation->factory_id == $factory_id;
                })
                ->filter(function ($item) use ($department_id) {
                    return $item->user->affiliation->department_id == $department_id;
                })
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id != null &&
            $department_id == null &&
            $report_id != null &&
            $reason_id == null &&
            $month == null
        ) {
            # 所属1,休暇種類を指定
            $reports = $reports
                ->filter(function ($item) use ($factory_id) {
                    return $item->user->affiliation->factory_id == $factory_id;
                })
                ->where('report_id', $report_id)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id != null &&
            $department_id == null &&
            $report_id == null &&
            $reason_id != null &&
            $month == null
        ) {
            # 所属1,理由を指定
            $reports = $reports
                ->filter(function ($item) use ($factory_id) {
                    return $item->user->affiliation->factory_id == $factory_id;
                })
                ->where('reason_id', $reason_id)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id != null &&
            $department_id == null &&
            $report_id == null &&
            $reason_id == null &&
            $month != null
        ) {
            # 所属1,月を指定
            $reports = $reports
                ->filter(function ($item) use ($factory_id) {
                    return $item->user->affiliation->factory_id == $factory_id;
                })
                ->where('start_date', '>=', $start_date)
                ->where('start_date', '<=', $end_date)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id == null &&
            $department_id != null &&
            $report_id != null &&
            $reason_id == null &&
            $month == null
        ) {
            # 所属2,休暇種類を指定
            $reports = $reports
                ->filter(function ($item) use ($department_id) {
                    return $item->user->affiliation->department_id == $department_id;
                })
                ->where('report_id', $report_id)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id == null &&
            $department_id != null &&
            $report_id == null &&
            $reason_id != null &&
            $month == null
        ) {
            # 所属2,理由を指定
            $reports = $reports
                ->filter(function ($item) use ($department_id) {
                    return $item->user->affiliation->department_id == $department_id;
                })
                ->where('reason_id', $reason_id)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id == null &&
            $department_id != null &&
            $report_id == null &&
            $reason_id == null &&
            $month != null
        ) {
            # 所属2,月を指定
            $reports = $reports
                ->filter(function ($item) use ($department_id) {
                    return $item->user->affiliation->department_id == $department_id;
                })
                ->where('start_date', '>=', $start_date)
                ->where('start_date', '<=', $end_date)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id == null &&
            $department_id == null &&
            $report_id != null &&
            $reason_id != null &&
            $month == null
        ) {
            # 休暇種類,理由を指定
            $reports = $reports
                ->where('report_id', $report_id)
                ->where('reason_id', $reason_id)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id == null &&
            $department_id == null &&
            $report_id != null &&
            $reason_id == null &&
            $month != null
        ) {
            # 休暇種類,月を指定
            $reports = $reports
                ->where('report_id', $report_id)
                ->where('start_date', '>=', $start_date)
                ->where('start_date', '<=', $end_date)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id == null &&
            $department_id == null &&
            $report_id == null &&
            $reason_id != null &&
            $month != null
        ) {
            # 理由,月を指定
            $reports = $reports
                ->where('start_date', '>=', $start_date)
                ->where('start_date', '<=', $end_date)
                ->where('reason_id', $reason_id)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id != null &&
            $department_id != null &&
            $report_id != null &&
            $reason_id == null &&
            $month == null
        ) {
            # 所属,休暇種類を指定
            $reports = $reports
                ->filter(function ($item) use ($factory_id) {
                    return $item->user->affiliation->factory_id == $factory_id;
                })
                ->filter(function ($item) use ($department_id) {
                    return $item->user->affiliation->department_id == $department_id;
                })
                ->where('report_id', $report_id)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id != null &&
            $department_id != null &&
            $report_id == null &&
            $reason_id != null &&
            $month == null
        ) {
            # 所属,理由を指定
            $reports = $reports
                ->filter(function ($item) use ($factory_id) {
                    return $item->user->affiliation->factory_id == $factory_id;
                })
                ->filter(function ($item) use ($department_id) {
                    return $item->user->affiliation->department_id == $department_id;
                })
                ->where('reason_id', $reason_id)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id != null &&
            $department_id != null &&
            $report_id == null &&
            $reason_id == null &&
            $month != null
        ) {
            # 所属,月を指定
            $reports = $reports
                ->filter(function ($item) use ($factory_id) {
                    return $item->user->affiliation->factory_id == $factory_id;
                })
                ->filter(function ($item) use ($department_id) {
                    return $item->user->affiliation->department_id == $department_id;
                })
                ->where('start_date', '>=', $start_date)
                ->where('start_date', '<=', $end_date)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id == null &&
            $department_id != null &&
            $report_id != null &&
            $reason_id != null &&
            $month == null
        ) {
            # 所属2,休暇種類,理由を指定
            $reports = $reports
                ->filter(function ($item) use ($department_id) {
                    return $item->user->affiliation->department_id == $department_id;
                })
                ->where('report_id', $report_id)
                ->where('reason_id', $reason_id)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id == null &&
            $department_id != null &&
            $report_id != null &&
            $reason_id == null &&
            $month != null
        ) {
            # 所属2,休暇種類,月を指定
            $reports = $reports
                ->filter(function ($item) use ($department_id) {
                    return $item->user->affiliation->department_id == $department_id;
                })
                ->where('start_date', '>=', $start_date)
                ->where('start_date', '<=', $end_date)
                ->where('report_id', $report_id)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id == null &&
            $department_id != null &&
            $report_id == null &&
            $reason_id != null &&
            $month != null
        ) {
            # 所属2,理由,月を指定
            $reports = $reports
                ->filter(function ($item) use ($department_id) {
                    return $item->user->affiliation->department_id == $department_id;
                })
                ->where('start_date', '>=', $start_date)
                ->where('start_date', '<=', $end_date)
                ->where('reason_id', $reason_id)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id == null &&
            $department_id == null &&
            $report_id != null &&
            $reason_id != null &&
            $month != null
        ) {
            # 休暇種類,理由,月を指定
            $reports = $reports
                ->where('start_date', '>=', $start_date)
                ->where('start_date', '<=', $end_date)
                ->where('report_id', $report_id)
                ->where('reason_id', $reason_id)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id != null &&
            $department_id != null &&
            $report_id != null &&
            $reason_id != null &&
            $month == null
        ) {
            # 所属,休暇種類,理由を指定
            $reports = $reports
                ->filter(function ($item) use ($factory_id) {
                    return $item->user->affiliation->factory_id == $factory_id;
                })
                ->filter(function ($item) use ($department_id) {
                    return $item->user->affiliation->department_id == $department_id;
                })
                ->where('report_id', $report_id)
                ->where('reason_id', $reason_id)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id != null &&
            $department_id != null &&
            $report_id != null &&
            $reason_id == null &&
            $month != null
        ) {
            # 所属,休暇種類,月を指定
            $reports = $reports
                ->filter(function ($item) use ($factory_id) {
                    return $item->user->affiliation->factory_id == $factory_id;
                })
                ->filter(function ($item) use ($department_id) {
                    return $item->user->affiliation->department_id == $department_id;
                })
                ->where('report_id', $report_id)
                ->where('start_date', '>=', $start_date)
                ->where('start_date', '<=', $end_date)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id != null &&
            $department_id != null &&
            $report_id == null &&
            $reason_id != null &&
            $month != null
        ) {
            # 所属,理由,月を指定
            $reports = $reports
                ->filter(function ($item) use ($factory_id) {
                    return $item->user->affiliation->factory_id == $factory_id;
                })
                ->filter(function ($item) use ($department_id) {
                    return $item->user->affiliation->department_id == $department_id;
                })
                ->where('reason_id', $reason_id)
                ->where('start_date', '>=', $start_date)
                ->where('start_date', '<=', $end_date)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id != null &&
            $department_id == null &&
            $report_id != null &&
            $reason_id != null &&
            $month != null
        ) {
            # 所属1,休暇種類,理由,月を指定
            $reports = $reports
                ->filter(function ($item) use ($factory_id) {
                    return $item->user->affiliation->factory_id == $factory_id;
                })
                ->where('report_id', $report_id)
                ->where('reason_id', $reason_id)
                ->where('start_date', '>=', $start_date)
                ->where('start_date', '<=', $end_date)
                ->where('approved', 1)
                ->where('cancel', 0);
        } elseif (
            $factory_id == null &&
            $department_id != null &&
            $report_id != null &&
            $reason_id != null &&
            $month != null
        ) {
            # 所属2,休暇種類,理由,月を指定
            $reports = $reports
                ->filter(function ($item) use ($department_id) {
                    return $item->user->affiliation->department_id == $department_id;
                })
                ->where('report_id', $report_id)
                ->where('reason_id', $reason_id)
                ->where('start_date', '>=', $start_date)
                ->where('start_date', '<=', $end_date)
                ->where('approved', 1)
                ->where('cancel', 0);
        }
        // $reports->load(['user', 'user.factory', 'user.department', 'report_category', 'reason_category']);

        $view = view('reports.export')->with(compact('reports'));
        return Excel::download(new ReportFormExport($view), 'reports.xlsx');

        // FIXME:権限で絞り込んでいないので表示どおりに出力されない
        /** 設定条件を定義して出力するreportを絞り込む
         * factory_id 工場
         * user_id ユーザー
         * report_id 休暇種類
         * month 月
         */
        $factory_id = $request->factory_id;
        $user_id = $request->user_id;
        $report_id = $request->report_category_id;
        $month = $request->get_month;

        # monthから月初め日、月終わり日を定義
        if ($month) {
            $carbon = new Carbon($month);
            $start_date = $carbon->format('Y-m-d');
            $end_date = $carbon
                ->addMonth()
                ->subDay()
                ->format('Y-m-d');
        }

        /** 条件に従って帳票出力するreportを取得 */
        if (
            $factory_id == null &&
            $report_id == null &&
            $user_id == null &&
            $month == null
        ) {
            # 全て出力
            $reports = Report::with(
                'user',
                'report_category',
                'sub_report_category',
                'reason_category'
            )
                ->where('approved', 1)
                ->where('cancel', 0)
                ->get();
        } elseif (
            $factory_id != null &&
            $report_id == null &&
            $user_id == null &&
            $month == null
        ) {
            # 工場を指定
            $reports = Report::with(
                'user',
                'report_category',
                'sub_report_category',
                'reason_category'
            )
                ->whereHas('user', function ($query) use ($factory_id) {
                    $query->where('factory_id', $factory_id);
                })
                ->where('approved', 1)
                ->where('cancel', 0)
                ->get();
        } elseif (
            $factory_id == null &&
            $report_id != null &&
            $user_id == null &&
            $month == null
        ) {
            # 休暇種類を指定
            $reports = Report::with(
                'user',
                'report_category',
                'sub_report_category',
                'reason_category'
            )
                ->where('report_id', $report_id)
                ->where('approved', 1)
                ->where('cancel', 0)
                ->get();
        } elseif (
            $factory_id == null &&
            $report_id == null &&
            $user_id != null &&
            $month == null
        ) {
            # ユーザーを指定
            $reports = Report::with(
                'user',
                'report_category',
                'sub_report_category',
                'reason_category'
            )
                ->where('user_id', $user_id)
                ->where('approved', 1)
                ->where('cancel', 0)
                ->get();
        } elseif (
            $factory_id == null &&
            $report_id == null &&
            $user_id == null &&
            $month != null
        ) {
            # 月を指定
            $reports = Report::with(
                'user',
                'report_category',
                'sub_report_category',
                'reason_category'
            )
                ->where('start_date', '>=', $start_date)
                ->where('start_date', '<=', $end_date)
                ->where('approved', 1)
                ->where('cancel', 0)
                ->get();
        } elseif (
            $factory_id != null &&
            $report_id != null &&
            $user_id == null &&
            $month == null
        ) {
            # 工場,休暇種類を指定
            $reports = Report::with(
                'user',
                'report_category',
                'sub_report_category',
                'reason_category'
            )
                ->whereHas('user', function ($query) use ($factory_id) {
                    $query->where('factory_id', $factory_id);
                })
                ->where('report_id', $report_id)
                ->where('approved', 1)
                ->where('cancel', 0)
                ->get();
        } elseif (
            $factory_id != null &&
            $report_id == null &&
            $user_id != null &&
            $month == null
        ) {
            # 工場,ユーザーを指定
            $reports = Report::with(
                'user',
                'report_category',
                'sub_report_category',
                'reason_category'
            )
                ->whereHas('user', function ($query) use ($factory_id) {
                    $query->where('factory_id', $factory_id);
                })
                ->where('user_id', $user_id)
                ->where('approved', 1)
                ->where('cancel', 0)
                ->get();
        } elseif (
            $factory_id != null &&
            $report_id == null &&
            $user_id == null &&
            $month != null
        ) {
            # 工場,月を指定
            $reports = Report::with(
                'user',
                'report_category',
                'sub_report_category',
                'reason_category'
            )
                ->whereHas('user', function ($query) use ($factory_id) {
                    $query->where('factory_id', $factory_id);
                })
                ->where('start_date', '>=', $start_date)
                ->where('start_date', '<=', $end_date)
                ->where('approved', 1)
                ->where('cancel', 0)
                ->get();
        } elseif (
            $factory_id == null &&
            $report_id != null &&
            $user_id != null &&
            $month == null
        ) {
            # 休暇種類,ユーザーを指定
            $reports = Report::with(
                'user',
                'report_category',
                'sub_report_category',
                'reason_category'
            )
                ->where('report_id', $report_id)
                ->where('user_id', $user_id)
                ->where('approved', 1)
                ->where('cancel', 0)
                ->get();
        } elseif (
            $factory_id == null &&
            $report_id != null &&
            $user_id == null &&
            $month != null
        ) {
            # 休暇種類,月を指定
            $reports = Report::with(
                'user',
                'report_category',
                'sub_report_category',
                'reason_category'
            )
                ->where('report_id', $report_id)
                ->where('start_date', '>=', $start_date)
                ->where('start_date', '<=', $end_date)
                ->where('approved', 1)
                ->where('cancel', 0)
                ->get();
        } elseif (
            $factory_id == null &&
            $report_id == null &&
            $user_id != null &&
            $month != null
        ) {
            # ユーザー,月を指定
            $reports = Report::with(
                'user',
                'report_category',
                'sub_report_category',
                'reason_category'
            )
                ->where('start_date', '>=', $start_date)
                ->where('start_date', '<=', $end_date)
                ->where('user_id', $user_id)
                ->where('approved', 1)
                ->where('cancel', 0)
                ->get();
        } elseif (
            $factory_id != null &&
            $report_id != null &&
            $user_id != null &&
            $month == null
        ) {
            # 工場,休暇種類,ユーザーを指定
            $reports = Report::with(
                'user',
                'report_category',
                'sub_report_category',
                'reason_category'
            )
                ->whereHas('user', function ($query) use ($factory_id) {
                    $query->where('factory_id', $factory_id);
                })
                ->where('report_id', $report_id)
                ->where('user_id', $user_id)
                ->where('approved', 1)
                ->where('cancel', 0)
                ->get();
        } elseif (
            $factory_id != null &&
            $report_id != null &&
            $user_id == null &&
            $month != null
        ) {
            # 工場,休暇種類,月を指定
            $reports = Report::with(
                'user',
                'report_category',
                'sub_report_category',
                'reason_category'
            )
                ->whereHas('user', function ($query) use ($factory_id) {
                    $query->where('factory_id', $factory_id);
                })
                ->where('start_date', '>=', $start_date)
                ->where('start_date', '<=', $end_date)
                ->where('report_id', $report_id)
                ->where('approved', 1)
                ->where('cancel', 0)
                ->get();
        } elseif (
            $factory_id != null &&
            $report_id == null &&
            $user_id != null &&
            $month != null
        ) {
            # 工場,ユーザー,月を指定
            $reports = Report::with(
                'user',
                'report_category',
                'sub_report_category',
                'reason_category'
            )
                ->whereHas('user', function ($query) use ($factory_id) {
                    $query->where('factory_id', $factory_id);
                })
                ->where('start_date', '>=', $start_date)
                ->where('start_date', '<=', $end_date)
                ->where('user_id', $user_id)
                ->where('approved', 1)
                ->where('cancel', 0)
                ->get();
        } elseif (
            $factory_id == null &&
            $report_id != null &&
            $user_id != null &&
            $month != null
        ) {
            # 休暇種類,ユーザー,月を指定
            $reports = Report::with(
                'user',
                'report_category',
                'sub_report_category',
                'reason_category'
            )
                ->where('start_date', '>=', $start_date)
                ->where('start_date', '<=', $end_date)
                ->where('report_id', $report_id)
                ->where('user_id', $user_id)
                ->where('approved', 1)
                ->where('cancel', 0)
                ->get();
        }
        // dd($reports);
        $view = view('reports.export')->with(compact('reports'));
        return Excel::download(new ReportFormExport($view), 'reports.xlsx');
    }

    public function all_export()
    {
        # 全データ出力
        return Excel::download(new MultipleExport(), 'pp.xlsx');
    }

    // public function source_export()
    // {
    //     # 全データ出力
    //     return Excel::download(new ReportSourceExport(), 'reports.xlsx');
    // }
}
