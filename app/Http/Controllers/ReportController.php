<?php

namespace App\Http\Controllers;

use App\Exports\MultipleExport;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\ReasonCategory;
use App\Models\AcquisitionDay;
use App\Models\Report;
use App\Models\ReportCategory;
use App\Models\SubReportCategory;
use App\Models\ShiftCategory;
use App\Models\User;
use App\Models\Approval;
use App\Exports\ReportFormExport;
use App\Imports\ReportImport;
use App\Models\Affiliation;
use App\Models\Calender;
use App\Models\Reason;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // index()
    public function index()
    {
        // 管理者権限は設定についての権限なので、一覧に影響しない
        // 管理者権限以外の権限を取得
        $approvals = Auth::user()
            ->approvals->where('approval_id', '!=', 1)
            ->load('affiliation');
        // 権限に当てはまるユーザーの申請を取得
        $reports = Report::whereHas('user.affiliation', function ($query) use (
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
                        } elseif (
                            $approval->affiliation->department_id != 1 &&
                            $approval->affiliation->group_id == 1
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
                        } elseif (
                            $approval->affiliation->department_id != 1 &&
                            $approval->affiliation->group_id != 1
                        ) {
                            $query
                                ->where(
                                    'factory_id',
                                    $approval->affiliation->factory_id
                                )
                                ->where(
                                    'department_id',
                                    $approval->affiliation->department_id
                                )
                                ->where(
                                    'group_id',
                                    $approval->affiliation->group_id
                                );
                        }
                    });
                }
                // 工場長を追加
                $query->orWhere(function ($query) use ($approval) {
                    $query
                        ->where(
                            'factory_id',
                            $approval->affiliation->factory_id
                        )
                        ->where('department_id', 1);
                });
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
                    'user.affiliation.factory',
                    'user.affiliation.department',
                    'user.affiliation.group',
                    'report_category',
                    'shift_category',
                    'sub_report_category',
                ])
                ->sortBy('report_id')
                ->sortBy('user.affiliation_id')
                ->sortByDesc('start_date')
                ->sortByDesc('report_date');
        }
        // 現在のページ番号からページ番号と1ページあたりのアイテム数を指定
        $page = request()->get('page', 1);
        $perPage = 10; // 1ページあたりのアイテム数

        // コレクションをページネーションする
        $paginator = new LengthAwarePaginator(
            $reports->forPage($page, $perPage), // ページに表示するアイテム取得
            $reports->count(), // 全体のアイテム数
            $perPage, // 1ページあたりのアイテム数
            $page, // 現在のページ番号
            ['path' => request()->url()] // ページネーションリンクのURLを指定
        );

        $affiliations = Affiliation::all()->load([
            'factory',
            'department',
            'group',
        ]);
        $reportCategories = ReportCategory::all();
        $reasonCategories = ReasonCategory::all();
        $users = User::all('id', 'employee', 'name')->sortBy('employee');

        return view('reports.index')->with(
            compact(
                // 'reports',
                'paginator',
                'affiliations',
                'reportCategories',
                'users'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // create()
    public function create()
    {
        $subReportCategories = SubReportCategory::all();
        $reasons = ReasonCategory::all();
        $reportReasons = Reason::with('reason_category')->get();
        $shifts = ShiftCategory::all();
        $myAcquisitionDays = Auth::user()->acquisition_days->load(
            'report_category.reports.shift_category'
        );
        $myReports = Auth::user()->reports->load('shift_category');
        $holidayCalender = Calender::whereHas('calender_category', function (
            $query
        ) {
            $query
                ->where(
                    'calender_id',
                    Auth::user()->affiliation->calender_category->id
                )
                ->where('date_id', 1);
        })->get('date');
        $businessDayCalender = Calender::whereHas(
            'calender_category',
            function ($query) {
                $query
                    ->where(
                        'calender_id',
                        Auth::user()->affiliation->calender_category->id
                    )
                    ->where('date_id', 2);
            }
        )->get('date');

        /** 残日数が0ではないreport_categoryを取得 */
        $reportCategories = ReportCategory::whereHas(
            'acquisition_days',
            function ($query) {
                $query
                    ->where('remaining_days', '!=', 0)
                    ->where('user_id', Auth::user()->id);
            }
        )
            ->orWhere(function ($query) {
                $query->where('max_days', null);
            })
            ->get()
            ->load('acquisition_form');

        // 新入社員で有給取得できない場合
        $releaseDate = now()
            ->subMonth(3)
            ->format('Y-m-d');
        if (Auth::user()->adoption_date > $releaseDate) {
            $reportCategories = $reportCategories->reject(function ($query) {
                return $query->id == 1;
            });
        }

        /** バースデイ休暇の取得期間外の場合は、バースデイ休暇をreport_categoriesから除く */
        $birthday = new Carbon(
            Carbon::now()->year . '-' . Auth::user()->birthday
        ); # 誕生日
        if (
            now()->subMonths(1) > $birthday ||
            now()->addMonths(1) < $birthday
        ) {
            $reportCategories = $reportCategories->where('id', '!=', 2);
        }

        return view('reports.create')->with(
            compact(
                'reportCategories',
                'subReportCategories',
                'reasons',
                'reportReasons',
                'shifts',
                'myAcquisitionDays',
                'myReports',
                'holidayCalender',
                'businessDayCalender'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReportRequest  $request
     * @return \Illuminate\Http\Response
     */
    // store()
    public function store(StoreReportRequest $request)
    {
        // 二重送信防止
        $request->session()->regenerateToken();
        // リクエストログ
        Log::info('Request data:', $request->all());

        // バリデーション
        if ($request->sub_report_id == 1) {
            # 終日休
            $request->validate(
                [
                    'acquisition_days' => [Rule::in(1.0)],
                ],
                [
                    'acquisition_days.in' => '終日休は1日で届出してください。',
                ]
            );
        }
        if ($request->sub_report_id == 2) {
            # 連休
            $request->validate(
                [
                    'end_date' => 'required',
                    'acquisition_days' => 'integer|min:1',
                    'acquisition_hours' => [Rule::in(0)],
                    'acquisition_minutes' => [Rule::in(0)],
                ],
                [
                    'acquisition_days.min' =>
                        '連休は:attributeが:min日以上で届出してください。',
                ]
            );
        }
        if ($request->sub_report_id == 3) {
            # 半日休暇
            $request->validate(
                [
                    'am_pm' => 'required',
                    'acquisition_days' => [Rule::in(0)],
                    'acquisition_hours' => [Rule::in(4, 3, 2)],
                    'acquisition_minutes' => [Rule::in(0, 30)],
                ],
                [
                    'acquisition_hours.in' =>
                        '半日休は2時間、2時間半、3時間、3時間半、4時間で届出してください。',
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
                    'acquisition_days' => [Rule::in(0)],
                    'acquisition_hours' => [Rule::in(0, 1, 2, 3, 4, 5, 6, 7)],
                ],
                [
                    'acquisition_hours.in' =>
                        '時間休は1時間単位で届出してください。',
                ]
            );
        }

        $applyOnTheDay = ReportCategory::where('apply_on_the_day', 1)->get();
        if (!$applyOnTheDay->contains('id', $request->report_id)) {
            $request->validate([
                'start_date' => 'after:today',
            ]);
        }

        if (
            $request->report_id == 13 || # 遅刻
            $request->report_id == 14 || # 早退
            $request->report_id == 15 # 外出
        ) {
            $request->validate(
                [
                    'start_time' => 'required',
                    'end_time' => 'required',
                    'acquisition_days' => [Rule::in(0)],
                    'acquisition_minutes' => [Rule::in(0, 15, 30, 45)],
                ],
                [
                    'acquisition_minutes.in' =>
                        '遅刻・早退・外出は15分単位で届出してください。',
                ]
            );
        }
        if ($request->reason_id == 1 || $request->reason_id == 2) {
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
        $acquisitionDay = AcquisitionDay::where('user_id', $request->user_id)
            ->where('report_id', $request->report_id)
            ->first();
        if (!empty($acquisitionDay->remaining_days)) {
            $remainingDays =
                $acquisitionDay->remaining_days -
                $acquisitionDay->pending_acquisition_days -
                $request->acquisition_days;
            $remainingHours =
                $acquisitionDay->remaining_hours -
                $acquisitionDay->pending_acquisition_hours -
                $request->acquisition_hours;
            $remainingMinutes =
                $acquisitionDay->remaining_minutes -
                $acquisitionDay->pending_acquisition_minutes -
                $request->acquisition_minutes;
            if ($remainingMinutes < 0) {
                $remainingHours -= 1;
            }
            if ($remainingHours < 0) {
                $remainingDays -= 1;
            }
            if ($remainingDays < 0) {
                throw ValidationException::withMessages([
                    'acquisition_days' => ['取得上限を超えています'],
                ]);
            }
        }

        // 当日申請可能な休暇は適用外
        $startDate = new Carbon($request->start_date);
        $now = Carbon::now();
        if (
            !$applyOnTheDay->contains('id', $request->report_id) &&
            $now->addDay() >= $startDate->addHour(16)
        ) {
            throw ValidationException::withMessages([
                'start_date' => [
                    '前日までに提出が必要な休暇は、前日の16時までに提出してください',
                ],
            ]);
        }

        # reportsレコード作成
        $report = new Report();
        $report->fill($request->all());

        /** 部長・工場長承認権限がある者が自身の申請を承認する */
        if (
            !empty(
                Auth::user()
                    ->approvals->where(
                        'affiliation.factory_id',
                        $report->user->affiliation->factory_id
                    )
                    ->where('approval_id', 2)
                    ->first()
            )
        ) {
            $report->approval1 = 1;
            $report->approval2 = 1;
            $report->approved = 1;

            DB::beginTransaction(); # トランザクション開始
            try {
                self::acquisitionSave($report);
                DB::commit(); # トランザクション成功終了
                // 管轄内の課長・GLにメール通知
                $glApprovers = Approval::whereHas('affiliation', function (
                    $query
                ) use ($report) {
                    $query
                        ->where(
                            'factory_id',
                            $report->user->affiliation->factory_id
                        )
                        ->where(
                            'department_id',
                            $report->user->affiliation->department_id
                        )
                        ->where(function ($query) use ($report) {
                            $query
                                ->where(
                                    'group_id',
                                    $report->user->affiliation->group_id
                                )
                                ->orWhere('group_id', 1);
                        });
                })
                    ->where('approval_id', 3)
                    ->with('user')
                    ->get();
                // 承認済みをメール通知
                if ($glApprovers) {
                    foreach ($glApprovers as $approval) {
                        $approval->user->Approved($report);
                    }
                }
                // リダイレクト
                return redirect()
                    ->route('reports.show', $report)
                    ->with('notice', 'Approved');
            } catch (\Exception $e) {
                DB::rollBack(); # トランザクション失敗終了
                // 例外情報をログに出力
                Log::error('Exception caught: ' . $e->getMessage());
                // return back()->with($e);
                return back()->withErrors('エラーが発生しました');
            }
        }

        /** 課長・GL承認権限がある者が自身の申請を承認する */
        if (
            !empty(
                Auth::user()
                    ->approvals->where(
                        'affiliation.factory_id',
                        $report->user->affiliation->factory_id
                    )
                    ->where(
                        'affiliation.department_id',
                        $report->user->affiliation->department_id
                    )
                    ->where('approval_id', 3)
                    ->first()
            )
        ) {
            $report->approval2 = 1;
            try {
                $report->save();

                // 工場長にメール
                $approvers = User::whereHas('approvals', function ($query) use (
                    $report
                ) {
                    $query
                        ->where('approval_id', 2)
                        ->whereHas('affiliation', function ($query) use (
                            $report
                        ) {
                            $query
                                ->where(
                                    'factory_id',
                                    $report->user->affiliation->factory_id
                                )
                                ->where(function ($query) use ($report) {
                                    $query
                                        ->orWhere(
                                            'department_id',
                                            $report->user->affiliation
                                                ->department_id
                                        )
                                        ->orWhere('department_id', 1);
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
                return back()->withErrors('エラーが発生しました');
            }
        }

        /** GLの承認後でないと工場長は承認できないようにするための付加 start */
        $glApprovers = Approval::whereHas('affiliation', function (
            $query
        ) use ($report) {
            $query
                ->where('factory_id', $report->user->affiliation->factory_id)
                ->where(
                    'department_id',
                    $report->user->affiliation->department_id
                )
                ->where(function ($query) use ($report) {
                    $query
                        ->where(
                            'group_id',
                            $report->user->affiliation->group_id
                        )
                        ->orWhere('group_id', 1);
                });
        })
            ->where('approval_id', 3)
            ->get();

        // GLがいないとき工場長がGL承認する
        if (empty($glApprovers->first())) {
            $report->approval2 = 1;
        }
        /** GLの承認後でないと工場長は承認できないようにするための付加 end */

        /** 一般的な届出 */
        try {
            $report->save();

            // TODO:権限の組み合わせにルールをつける。以下に無い組み合わせが発生する可能性あり
            // 2はdepartmentまでgroupは必ず1
            // 3はgroupまで　1かそれ以外
            // 申請者のapprovers
            $approvers = User::whereHas('approvals', function ($query) use (
                $report
            ) {
                $query
                    ->where(function ($query) use ($report) {
                        $query
                            ->where('approval_id', 2)
                            ->whereHas('affiliation', function ($query) use (
                                $report
                            ) {
                                $query
                                    ->where(
                                        'factory_id',
                                        $report->user->affiliation->factory_id
                                    )
                                    ->where(function ($query) use ($report) {
                                        $query
                                            ->orWhere(
                                                'department_id',
                                                $report->user->affiliation
                                                    ->department_id
                                            )
                                            ->orWhere('department_id', 1);
                                    });
                            });
                    })
                    ->orWhere(function ($query) use ($report) {
                        $query
                            ->where('approval_id', 3)
                            ->whereHas('affiliation', function ($query) use (
                                $report
                            ) {
                                $query
                                    ->where(
                                        'factory_id',
                                        $report->user->affiliation->factory_id
                                    )
                                    ->where(
                                        'department_id',
                                        $report->user->affiliation
                                            ->department_id
                                    )
                                    ->where(function ($query) use ($report) {
                                        $query
                                            ->orWhere(
                                                'group_id',
                                                $report->user->affiliation
                                                    ->group_id
                                            )
                                            ->orWhere('group_id', 1);
                                    });
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
            return back()->withErrors('エラーが発生しました');
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
    // edit()
    public function edit(Report $report)
    {
        $subReportCategories = SubReportCategory::all();
        $reasons = ReasonCategory::all();
        $reportReasons = Reason::with('reason_category')->get();
        $shifts = ShiftCategory::all();
        $myAcquisitionDays = Auth::user()->acquisition_days->load(
            'report_category.reports.shift_category'
        );
        $myReports = Auth::user()
            ->reports->where('id', '!=', $report->id)
            ->load('shift_category');
        $holidayCalender = Calender::whereHas('calender_category', function (
            $query
        ) {
            $query
                ->where(
                    'calender_id',
                    Auth::user()->affiliation->calender_category->id
                )
                ->where('date_id', 1);
        })->get('date');
        $businessDayCalender = Calender::whereHas(
            'calender_category',
            function ($query) {
                $query
                    ->where(
                        'calender_id',
                        Auth::user()->affiliation->calender_category->id
                    )
                    ->where('date_id', 2);
            }
        )->get('date');

        $reportCategories = ReportCategory::whereHas(
            'acquisition_days',
            function ($query) {
                $query
                    // nullと0を判別できている
                    ->where('remaining_days', '!=', 0)
                    ->where('user_id', Auth::user()->id);
            }
        )
            ->orWhere(function ($query) {
                $query->where('max_days', null);
            })
            ->get();

        $birthday = new Carbon(
            Carbon::now()->year . '-' . Auth::user()->birthday
        ); # 誕生日
        if (
            now()->subMonths(3) > $birthday ||
            now()->addMonths(3) < $birthday
        ) {
            $reportCategories = $reportCategories->where('id', '!=', 2);
        }

        return view('reports.edit')->with(
            compact(
                'report',
                'reportCategories',
                'subReportCategories',
                'reasons',
                'reportReasons',
                'shifts',
                'myAcquisitionDays',
                'myReports',
                'holidayCalender',
                'businessDayCalender'
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
    // update()
    public function update(UpdateReportRequest $request, Report $report)
    {
        // 二重送信防止
        $request->session()->regenerateToken();
        Log::info('Request data:', $request->all());

        // バリデーション
        if ($request->sub_report_id == 1) {
            # 終日休
            $request->validate(
                [
                    'acquisition_days' => [Rule::in(1.0)],
                ],
                [
                    'acquisition_days.in' => '終日休は1日で届出してください。',
                ]
            );
        }
        if ($request->sub_report_id == 2) {
            # 連休
            $request->validate(
                [
                    'end_date' => 'required',
                    'acquisition_days' => 'integer|min:1',
                    'acquisition_hours' => [Rule::in(0)],
                    'acquisition_minutes' => [Rule::in(0)],
                ],
                [
                    'acquisition_days.min' =>
                        '連休は:attributeが:min日以上で届出してください。',
                ]
            );
        }
        if ($request->sub_report_id == 3) {
            # 半日休暇
            $request->validate(
                [
                    'am_pm' => 'required',
                    'acquisition_days' => [Rule::in(0)],
                    'acquisition_hours' => [Rule::in(4, 3, 2)],
                    'acquisition_minutes' => [Rule::in(0, 30)],
                ],
                [
                    'acquisition_hours.in' =>
                        '半日休は2時間、2時間半、3時間、3時間半、4時間で届出してください。',
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
                    'acquisition_days' => [Rule::in(0)],
                    'acquisition_hours' => [Rule::in(0, 1, 2, 3, 4, 5, 6, 7)],
                ],
                [
                    'acquisition_hours.in' =>
                        '時間休は1時間単位で届出してください。',
                ]
            );
        }

        $applyOnTheDay = ReportCategory::where('apply_on_the_day', 1)->get();
        if (!$applyOnTheDay->contains('id', $request->report_id)) {
            $request->validate([
                'start_date' => 'after:today',
            ]);
        }

        if (
            $request->report_id == 13 || # 遅刻
            $request->report_id == 14 || # 早退
            $request->report_id == 15 # 外出
        ) {
            $request->validate(
                [
                    'start_time' => 'required',
                    'end_time' => 'required',
                    'acquisition_days' => [Rule::in(0)],
                    'acquisition_minutes' => [Rule::in(0, 15, 30, 45)],
                ],
                [
                    'acquisition_minutes.in' =>
                        '遅刻・早退・外出は15分単位で届出してください。',
                ]
            );
        }
        if ($request->reason_id == 1 || $request->reason_id == 2) {
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
        $acquisitionDay = AcquisitionDay::where('user_id', $request->user_id)
            ->where('report_id', $request->report_id)
            ->first();
        if (!empty($acquisitionDay->remaining_days)) {
            $remainingDays =
                $acquisitionDay->remaining_days -
                $acquisitionDay->pending_acquisition_days -
                $request->acquisition_days;
            $remainingHours =
                $acquisitionDay->remaining_hours -
                $acquisitionDay->pending_acquisition_hours -
                $request->acquisition_hours;
            $remainingMinutes =
                $acquisitionDay->remaining_minutes -
                $acquisitionDay->pending_acquisition_minutes -
                $request->acquisition_minutes;
            if ($remainingMinutes < 0) {
                $remainingHours -= 1;
            }
            if ($remainingHours < 0) {
                $remainingDays -= 1;
            }
            if ($remainingDays < 0) {
                throw ValidationException::withMessages([
                    'acquisition_days' => ['取得上限を超えています'],
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
                    ->approvals->where(
                        'affiliation.factory_id',
                        $report->user->affiliation->factory_id
                    )
                    ->where(
                        'affiliation.department_id',
                        $report->user->affiliation->department_id
                    )
                    ->where('approval_id', 3)
                    ->first()
            )
        ) {
            $report->approval2 = 1;
            try {
                $report->save();

                // 工場長にメール
                $approvers = User::whereHas('approvals', function ($query) use (
                    $report
                ) {
                    $query
                        ->where('approval_id', 2)
                        ->whereHas('affiliation', function ($query) use (
                            $report
                        ) {
                            $query
                                ->where(
                                    'factory_id',
                                    $report->user->affiliation->factory_id
                                )
                                ->where(function ($query) use ($report) {
                                    $query
                                        ->orWhere(
                                            'department_id',
                                            $report->user->affiliation
                                                ->department_id
                                        )
                                        ->orWhere('department_id', 1);
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
                return back()->withErrors('エラーが発生しました');
            }
        }

        /** GLの承認後でないと工場長は承認できないようにするための付加 start */
        $glApprovers = Approval::whereHas('affiliation', function (
            $query
        ) use ($report) {
            $query
                ->where('factory_id', $report->user->affiliation->factory_id)
                ->where(
                    'department_id',
                    $report->user->affiliation->department_id
                )
                ->where(function ($query) use ($report) {
                    $query
                        ->where(
                            'group_id',
                            $report->user->affiliation->group_id
                        )
                        ->orWhere('group_id', 1);
                });
        })
            ->where('approval_id', 3)
            ->get();

        // GLがいないとき工場長がGL承認する
        if (empty($glApprovers->first())) {
            $report->approval2 = 1;
        }
        /** GLの承認後でないと工場長は承認できないようにするための付加 end */

        /** 一般的な届出 */
        try {
            $report->save();

            // TODO:権限の組み合わせにルールをつける。以下に無い組み合わせが発生する可能性あり
            $approvers = User::whereHas('approvals', function ($query) use (
                $report
            ) {
                $query
                    ->where(function ($query) use ($report) {
                        $query
                            ->where('approval_id', 2)
                            ->whereHas('affiliation', function ($query) use (
                                $report
                            ) {
                                $query
                                    ->where(
                                        'factory_id',
                                        $report->user->affiliation->factory_id
                                    )
                                    ->where(function ($query) use ($report) {
                                        $query
                                            ->orWhere(
                                                'department_id',
                                                $report->user->affiliation
                                                    ->department_id
                                            )
                                            ->orWhere('department_id', 1);
                                    });
                            });
                    })
                    ->orWhere(function ($query) use ($report) {
                        $query
                            ->where('approval_id', 3)
                            ->whereHas('affiliation', function ($query) use (
                                $report
                            ) {
                                $query
                                    ->where(
                                        'factory_id',
                                        $report->user->affiliation->factory_id
                                    )
                                    ->where(
                                        'department_id',
                                        $report->user->affiliation
                                            ->department_id
                                    )
                                    ->where(function ($query) use ($report) {
                                        $query
                                            ->orWhere(
                                                'group_id',
                                                $report->user->affiliation
                                                    ->group_id
                                            )
                                            ->orWhere('group_id', 1);
                                    });
                            });
                    });
            })->get();

            if ($approvers) {
                foreach ($approvers as $approver) {
                    $approver->updateReport($report);
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
            return back()->withErrors('エラーが発生しました');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    // destroy()
    public function destroy(Report $report)
    {
        $report->cancel = 1; // キャンセルon

        // 一般の通知対象を用意
        // 申請者のapproverが通知対象
        $approvers = User::whereHas('approvals', function ($query) use (
            $report
        ) {
            $query
                ->where(function ($query) use ($report) {
                    $query
                        ->where('approval_id', 2)
                        ->whereHas('affiliation', function ($query) use (
                            $report
                        ) {
                            $query
                                ->where(
                                    'factory_id',
                                    $report->user->affiliation->factory_id
                                )
                                ->where(function ($query) use ($report) {
                                    $query
                                        ->orWhere(
                                            'department_id',
                                            $report->user->affiliation
                                                ->department_id
                                        )
                                        ->orWhere('department_id', 1);
                                });
                        });
                })
                ->orWhere(function ($query) use ($report) {
                    $query
                        ->where('approval_id', 3)
                        ->whereHas('affiliation', function ($query) use (
                            $report
                        ) {
                            $query
                                ->where(
                                    'factory_id',
                                    $report->user->affiliation->factory_id
                                )
                                ->where(
                                    'department_id',
                                    $report->user->affiliation->department_id
                                )
                                ->where(function ($query) use ($report) {
                                    $query
                                        ->orWhere(
                                            'group_id',
                                            $report->user->affiliation->group_id
                                        )
                                        ->orWhere('group_id', 1);
                                });
                        });
                });
        })->get();

        /** 部長・工場長承認権限がある者が自身の申請を取消す場合このスコープには入ってこない */
        /** approved_cancelメソッドで取消処理 */

        /** 課長・GL承認権限がある者が自身の申請を取消する */
        if (
            !empty(
                Auth::user()
                    ->approvals->where(
                        'affiliation.factory_id',
                        $report->user->factory_id
                    )
                    ->where(
                        'affiliation.department_id',
                        $report->user->department_id
                    )
                    ->where('approval_id', 3)
                    ->first()
            )
        ) {
            $report->approval2 = 0;

            // 部長・工場長だけ通知対象を上書き
            $approvers = User::whereHas('approvals', function ($query) use (
                $report
            ) {
                $query
                    ->where('approval_id', 2)
                    ->whereHas('affiliation', function ($query) use ($report) {
                        $query
                            ->where(
                                'factory_id',
                                $report->user->affiliation->factory_id
                            )
                            ->where(function ($query) use ($report) {
                                $query
                                    ->orWhere(
                                        'department_id',
                                        $report->user->affiliation
                                            ->department_id
                                    )
                                    ->orWhere('department_id', 1);
                            });
                    });
            })->get();
        }
        $report->save();

        // 承認がある場合
        if ($report->approval1 == 1 || $report->approval2 == 1) {
            // 工場長が承認している場合
            if ($report->approval1 == 1 && $report->approval2 == 0) {
                // 工場長に通知
                $notifiers = User::whereHas('approvals', function (
                    $query
                ) use ($report) {
                    $query
                        ->where('approval_id', 2)
                        ->whereHas('affiliation', function ($query) use (
                            $report
                        ) {
                            $query
                                ->where(
                                    'factory_id',
                                    $report->user->affiliation->factory_id
                                )
                                ->where(function ($query) use ($report) {
                                    $query
                                        ->where(
                                            'department_id',
                                            $report->user->affiliation
                                                ->department_id
                                        )
                                        ->orWhere('department_id', 1);
                                });
                        });
                })->get();
            }
            // Glが承認している場合
            if ($report->approval1 == 0 && $report->approval2 == 1) {
                $glApprovers = Approval::whereHas('affiliation', function (
                    $query
                ) use ($report) {
                    $query
                        ->where(
                            'factory_id',
                            $report->user->affiliation->factory_id
                        )
                        ->where(
                            'department_id',
                            $report->user->affiliation->department_id
                        )
                        ->where(function ($query) use ($report) {
                            $query
                                ->where(
                                    'group_id',
                                    $report->user->affiliation->group_id
                                )
                                ->orWhere('group_id', 1);
                        });
                })
                    ->where('approval_id', 3)
                    ->get();

                // GLがいない部署はGL承認を削除
                if (empty($glApprovers->first())) {
                    $report->approval2 = 0;
                }

                // GLに通知
                $notifiers = User::whereHas('approvals', function (
                    $query
                ) use ($report) {
                    $query
                        ->where('approval_id', 3)
                        ->whereHas('affiliation', function ($query) use (
                            $report
                        ) {
                            $query
                                ->where(
                                    'factory_id',
                                    $report->user->affiliation->factory_id
                                )
                                ->where(
                                    'department_id',
                                    $report->user->affiliation->department_id
                                )
                                ->where(function ($query) use ($report) {
                                    $query
                                        ->where(
                                            'group_id',
                                            $report->user->affiliation->group_id
                                        )
                                        ->orWhere('group_id', 1);
                                });
                        });
                })->get();
            }

            // 承認したapproversに取消確認の通知メール送信
            if ($notifiers->first()) {
                foreach ($notifiers as $notifier) {
                    $notifier->cancelReport($report);
                }
                return redirect()
                    ->route('reports.my_index')
                    ->with('notice', 'CancelReport');
            }
        }

        // 誰も承認していない場合、取消確認なしで削除
        if (
            $report->cancel == 1 &&
            $report->approval1 == 0 &&
            $report->approval2 == 0
        ) {
            try {
                $report->delete();

                // approversにメール
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
                return back()->withErrors('エラーが発生しました');
            }
        }
    }

    // search
    public function search(Request $request)
    {
        // 管理者権限は設定についての権限なので、一覧に影響しない
        $approvals = Auth::user()
            ->approvals->where('approval_id', '!=', 1)
            ->load('affiliation');
        // 権限に当てはまるユーザーの申請を取得
        $reports = Report::whereHas('user.affiliation', function ($query) use (
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
                        } elseif (
                            $approval->affiliation->department_id != 1 &&
                            $approval->affiliation->group_id == 1
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
                        } elseif (
                            $approval->affiliation->department_id != 1 &&
                            $approval->affiliation->group_id != 1
                        ) {
                            $query
                                ->where(
                                    'factory_id',
                                    $approval->affiliation->factory_id
                                )
                                ->where(
                                    'department_id',
                                    $approval->affiliation->department_id
                                )
                                ->where(
                                    'group_id',
                                    $approval->affiliation->group_id
                                );
                        }
                    });
                }
                // 工場長を追加
                $query->orWhere(function ($query) use ($approval) {
                    $query
                        ->where(
                            'factory_id',
                            $approval->affiliation->factory_id
                        )
                        ->where('department_id', 1);
                });
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
                    'user.affiliation.factory',
                    'user.affiliation.department',
                    'user.affiliation.group',
                    'report_category',
                    'shift_category',
                    'sub_report_category',
                ])
                ->sortBy('report_id')
                ->sortBy('user.affiliation_id')
                ->sortBy('start_date')
                ->sortByDesc('start_date')
                ->sortByDesc('report_date');
        }

        $affiliationId = $request->select_affiliation;
        $userId = $request->select_user;
        $reportId = $request->select_report;
        $month = $request->select_month;
        $affiliation = Affiliation::find($affiliationId);

        # monthから月初め日、月終わり日を定義
        if ($month) {
            $carbon = new Carbon($month);
            $startDate = $carbon->format('Y-m-d');
            $endDate = $carbon
                ->addMonth()
                ->subDay()
                ->format('Y-m-d');
        }

        /** 条件に従って帳票出力するreportを取得 */
        if ($affiliationId == 1) {
            if ($reportId != null && $userId == null && $month == null) {
                # 休暇種類を指定
                $reports = $reports->where('report_id', $reportId);
            } elseif (
                $reportId == null &&
                $userId != null &&
                $month == null
            ) {
                # 理由を指定
                $reports = $reports->where('user_id', $userId);
            } elseif (
                $reportId == null &&
                $userId == null &&
                $month != null
            ) {
                # 月を指定
                $reports = $reports
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate);
            } elseif (
                $reportId != null &&
                $userId != null &&
                $month == null
            ) {
                # 休暇種類,理由を指定
                $reports = $reports
                    ->where('report_id', $reportId)
                    ->where('user_id', $userId);
            } elseif (
                $reportId != null &&
                $userId == null &&
                $month != null
            ) {
                # 休暇種類,月を指定
                $reports = $reports
                    ->where('report_id', $reportId)
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate);
            } elseif (
                $reportId == null &&
                $userId != null &&
                $month != null
            ) {
                # 理由,月を指定
                $reports = $reports
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate)
                    ->where('user_id', $userId);
            } elseif (
                $reportId != null &&
                $userId != null &&
                $month != null
            ) {
                # 休暇種類,理由,月を指定
                $reports = $reports
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate)
                    ->where('report_id', $reportId)
                    ->where('user_id', $userId);
            }
        } else {
            if (
                $affiliationId != null &&
                $reportId == null &&
                $userId == null &&
                $month == null
            ) {
                # 所属を指定
                $reports = $reports->filter(function ($item) use (
                    $affiliationId,
                    $affiliation
                ) {
                    if ($affiliation->department_id == 1) {
                        return $item->user->affiliation->factory_id ==
                            $affiliation->factory_id;
                    } elseif (
                        $affiliation->department_id != 1 &&
                        $affiliation->group_id == 1
                    ) {
                        return $item->user->affiliation->factory_id ==
                            $affiliation->factory_id &&
                            $item->user->affiliation->department_id ==
                                $affiliation->department_id;
                    } else {
                        return $item->user->affiliation_id == $affiliationId;
                    }
                });
            } elseif (
                $affiliationId == null &&
                $reportId != null &&
                $userId == null &&
                $month == null
            ) {
                # 休暇種類を指定
                $reports = $reports->where('report_id', $reportId);
            } elseif (
                $affiliationId == null &&
                $reportId == null &&
                $userId != null &&
                $month == null
            ) {
                # 理由を指定
                $reports = $reports->where('user_id', $userId);
            } elseif (
                $affiliationId == null &&
                $reportId == null &&
                $userId == null &&
                $month != null
            ) {
                # 月を指定
                $reports = $reports
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate);
            } elseif (
                $affiliationId != null &&
                $reportId != null &&
                $userId == null &&
                $month == null
            ) {
                # 所属,休暇種類を指定
                $reports = $reports
                    ->filter(function ($item) use (
                        $affiliationId,
                        $affiliation
                    ) {
                        if ($affiliation->department_id == 1) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id;
                        } elseif (
                            $affiliation->department_id != 1 &&
                            $affiliation->group_id == 1
                        ) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id &&
                                $item->user->affiliation->department_id ==
                                    $affiliation->department_id;
                        } else {
                            return $item->user->affiliation_id ==
                                $affiliationId;
                        }
                    })
                    ->where('report_id', $reportId);
            } elseif (
                $affiliationId != null &&
                $reportId == null &&
                $userId != null &&
                $month == null
            ) {
                # 所属,理由を指定
                $reports = $reports
                    ->filter(function ($item) use (
                        $affiliationId,
                        $affiliation
                    ) {
                        if ($affiliation->department_id == 1) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id;
                        } elseif (
                            $affiliation->department_id != 1 &&
                            $affiliation->group_id == 1
                        ) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id &&
                                $item->user->affiliation->department_id ==
                                    $affiliation->department_id;
                        } else {
                            return $item->user->affiliation_id ==
                                $affiliationId;
                        }
                    })
                    ->where('user_id', $userId);
            } elseif (
                $affiliationId != null &&
                $reportId == null &&
                $userId == null &&
                $month != null
            ) {
                # 所属,月を指定
                $reports = $reports
                    ->filter(function ($item) use (
                        $affiliationId,
                        $affiliation
                    ) {
                        if ($affiliation->department_id == 1) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id;
                        } elseif (
                            $affiliation->department_id != 1 &&
                            $affiliation->group_id == 1
                        ) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id &&
                                $item->user->affiliation->department_id ==
                                    $affiliation->department_id;
                        } else {
                            return $item->user->affiliation_id ==
                                $affiliationId;
                        }
                    })
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate);
            } elseif (
                $affiliationId == null &&
                $reportId != null &&
                $userId != null &&
                $month == null
            ) {
                # 休暇種類,理由を指定
                $reports = $reports
                    ->where('report_id', $reportId)
                    ->where('user_id', $userId);
            } elseif (
                $affiliationId == null &&
                $reportId != null &&
                $userId == null &&
                $month != null
            ) {
                # 休暇種類,月を指定
                $reports = $reports
                    ->where('report_id', $reportId)
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate);
            } elseif (
                $affiliationId == null &&
                $reportId == null &&
                $userId != null &&
                $month != null
            ) {
                # 理由,月を指定
                $reports = $reports
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate)
                    ->where('user_id', $userId);
            } elseif (
                $affiliationId != null &&
                $reportId != null &&
                $userId != null &&
                $month == null
            ) {
                # 所属,休暇種類,理由を指定
                $reports = $reports
                    ->filter(function ($item) use (
                        $affiliationId,
                        $affiliation
                    ) {
                        if ($affiliation->department_id == 1) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id;
                        } elseif (
                            $affiliation->department_id != 1 &&
                            $affiliation->group_id == 1
                        ) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id &&
                                $item->user->affiliation->department_id ==
                                    $affiliation->department_id;
                        } else {
                            return $item->user->affiliation_id ==
                                $affiliationId;
                        }
                    })
                    ->where('report_id', $reportId)
                    ->where('user_id', $userId);
            } elseif (
                $affiliationId != null &&
                $reportId != null &&
                $userId == null &&
                $month != null
            ) {
                # 所属,休暇種類,月を指定
                $reports = $reports
                    ->filter(function ($item) use (
                        $affiliationId,
                        $affiliation
                    ) {
                        if ($affiliation->department_id == 1) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id;
                        } elseif (
                            $affiliation->department_id != 1 &&
                            $affiliation->group_id == 1
                        ) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id &&
                                $item->user->affiliation->department_id ==
                                    $affiliation->department_id;
                        } else {
                            return $item->user->affiliation_id ==
                                $affiliationId;
                        }
                    })
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate)
                    ->where('report_id', $reportId);
            } elseif (
                $affiliationId != null &&
                $reportId == null &&
                $userId != null &&
                $month != null
            ) {
                # 所属,理由,月を指定
                $reports = $reports
                    ->filter(function ($item) use (
                        $affiliationId,
                        $affiliation
                    ) {
                        if ($affiliation->department_id == 1) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id;
                        } elseif (
                            $affiliation->department_id != 1 &&
                            $affiliation->group_id == 1
                        ) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id &&
                                $item->user->affiliation->department_id ==
                                    $affiliation->department_id;
                        } else {
                            return $item->user->affiliation_id ==
                                $affiliationId;
                        }
                    })
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate)
                    ->where('user_id', $userId);
            } elseif (
                $affiliationId == null &&
                $reportId != null &&
                $userId != null &&
                $month != null
            ) {
                # 休暇種類,理由,月を指定
                $reports = $reports
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate)
                    ->where('report_id', $reportId)
                    ->where('user_id', $userId);
            } elseif (
                $affiliationId != null &&
                $reportId != null &&
                $userId != null &&
                $month != null
            ) {
                # すべて指定
                $reports = $reports
                    ->filter(function ($item) use (
                        $affiliationId,
                        $affiliation
                    ) {
                        if ($affiliation->department_id == 1) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id;
                        } elseif (
                            $affiliation->department_id != 1 &&
                            $affiliation->group_id == 1
                        ) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id &&
                                $item->user->affiliation->department_id ==
                                    $affiliation->department_id;
                        } else {
                            return $item->user->affiliation_id ==
                                $affiliationId;
                        }
                    })
                    ->where('report_id', $reportId)
                    ->where('user_id', $userId)
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate);
            }
        }

        // ページ番号と1ページあたりのアイテム数を指定
        $page = request()->get('page', 1); // 現在のページ番号を取得、デフォルトは1
        $perPage = 10; // 1ページあたりのアイテム数を設定

        // コレクションをページネーションする
        $paginator = new LengthAwarePaginator(
            $reports->forPage($page, $perPage), // ページに表示するアイテムを取得
            $reports->count(), // 全体のアイテム数
            $perPage, // 1ページあたりのアイテム数
            $page, // 現在のページ番号
            ['path' => request()->url()] // ページネーションリンクのURLを指定
        );

        $affiliations = Affiliation::all()->load([
            'factory',
            'department',
            'group',
        ]);
        $reportCategories = ReportCategory::all();
        $reasonCategories = ReasonCategory::all();
        $users = User::all('id', 'employee', 'name')->sortBy('employee');

        return view('reports.index')->with(
            compact(
                'paginator',
                'affiliations',
                'reportCategories',
                'reasonCategories',
                'users'
            )
        );
    }

    // myIndex()
    public function myIndex()
    {
        $reports = Auth::user()
            ->reports->load(['report_category', 'sub_report_category'])
            ->sortBy('start_date')
            ->sortBy('report_date');
        return view('reports.my_index')->with(compact('reports'));
    }

    /** 承認済み届出の取消申請 */
    // approvedCancel()
    public function approvedCancel(Report $report)
    {
        $report->cancel = 1; # キャンセルon
        $approvers = User::whereHas('approvals', function ($query) use (
            $report
        ) {
            $query
                ->where(function ($query) use ($report) {
                    $query
                        ->where('approval_id', 2)
                        ->whereHas('affiliation', function ($query) use (
                            $report
                        ) {
                            $query
                                ->where(
                                    'factory_id',
                                    $report->user->affiliation->factory_id
                                )
                                ->where(function ($query) use ($report) {
                                    $query
                                        ->orWhere(
                                            'department_id',
                                            $report->user->affiliation
                                                ->department_id
                                        )
                                        ->orWhere('department_id', 1);
                                });
                        });
                })
                ->orWhere(function ($query) use ($report) {
                    $query
                        ->where('approval_id', 3)
                        ->whereHas('affiliation', function ($query) use (
                            $report
                        ) {
                            $query
                                ->where(
                                    'factory_id',
                                    $report->user->affiliation->factory_id
                                )
                                ->where(
                                    'department_id',
                                    $report->user->affiliation->department_id
                                )
                                ->where(function ($query) use ($report) {
                                    $query
                                        ->orWhere(
                                            'group_id',
                                            $report->user->affiliation->group_id
                                        )
                                        ->orWhere('group_id', 1);
                                });
                        });
                });
        })->get();

        /** 部長承認権限をもつ者が自身の申請を取消す場合 */
        if (
            !empty(
                Auth::user()
                    ->approvals->where(
                        'affiliation.factory_id',
                        $report->user->affiliation->factory_id
                    )
                    ->where('approval_id', 2)
                    ->first()
            )
        ) {
            $report->approval1 = 0;
            $report->approval2 = 0;

            $glApprovers = Approval::whereHas('affiliation', function (
                $query
            ) use ($report) {
                $query
                    ->where(
                        'factory_id',
                        $report->user->affiliation->factory_id
                    )
                    ->where(
                        'department_id',
                        $report->user->affiliation->department_id
                    )
                    ->where(function ($query) use ($report) {
                        $query
                            ->where(
                                'group_id',
                                $report->user->affiliation->group_id
                            )
                            ->orWhere('group_id', 1);
                    });
            })
                ->where('approval_id', 3)
                ->get();

            $acquisitionDay = AcquisitionDay::all()
                ->where('report_id', $report->report_id)
                ->where('user_id', $report->user_id)
                ->first();

            DB::beginTransaction(); # トランザクション開始
            try {
                self::acquisitionCancel($report);
                // $report->save();
                // if (!empty($acquisitionDay)) {
                //     if (!empty($acquisitionDay->remaining_days)) {
                //         $acquisitionDay->remaining_days += $report->get_days;
                //     }
                //     $acquisitionDay->acquisition_days -= $report->get_days;
                //     $acquisitionDay->save(); # 残日数を保存
                // }
                // $report->delete();
                DB::commit(); # トランザクション成功終了
                // 管轄内の課長・GLにメール通知
                if ($glApprovers) {
                    foreach ($glApprovers as $approval) {
                        $approval->user->destroyReport($report);
                    }
                }
                // リダイレクト
                return redirect()
                    ->route('reports.my_index')
                    ->with('notice', 'DestroyReport');
            } catch (\Exception $e) {
                DB::rollBack(); # トランザクション失敗終了
                // 例外情報をログに出力
                Log::error('Exception caught: ' . $e->getMessage());
                // エラー内容をそのまま表示しない
                return back()->withErrors('エラーが発生しました');
            }
        }

        /** 課長・GL承認権限をもつ者が自身の申請を取消す場合 */
        if (
            !empty(
                Auth::user()
                    ->approvals->where(
                        'affiliation.factory_id',
                        $report->user->affiliation->factory_id
                    )
                    ->where(
                        'affiliation.department_id',
                        $report->user->affiliation->department_id
                    )
                    ->where('approval_id', 3)
                    ->first()
            )
        ) {
            $report->approval2 = 0; # 取消確認済み
            // 通知相手を上書き
            $approvers = User::whereHas('approvals', function ($query) use (
                $report
            ) {
                $query
                    ->where('approval_id', 2)
                    ->whereHas('affiliation', function ($query) use ($report) {
                        $query
                            ->where(
                                'factory_id',
                                $report->user->affiliation->factory_id
                            )
                            ->where(function ($query) use ($report) {
                                $query
                                    ->orWhere(
                                        'department_id',
                                        $report->user->affiliation
                                            ->department_id
                                    )
                                    ->orWhere('department_id', 1);
                            });
                    });
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
            return back()->withErrors('エラーが発生しました');
        }
    }

    // approval()
    public function approval(Report $report)
    {
        $approvals = Auth::user()->approvals->whereIn('approval_id', [2, 3]);
        // $gl_approval = Approval::where('approval_id', 3)
        //     ->where('factory_id', $report->user->factory_id)
        //     ->where('department_id', $report->user->department_id)
        //     ->where(function ($query) use ($report) {
        //         $query
        //             ->orWhere('group_id', $report->user->group_id)
        //             ->orWhere('group_id', 1);
        //     })
        //     ->get();
        $glApprovers = Approval::whereHas('affiliation', function (
            $query
        ) use ($report) {
            $query
                ->where('factory_id', $report->user->affiliation->factory_id)
                ->where(
                    'department_id',
                    $report->user->affiliation->department_id
                )
                ->where(function ($query) use ($report) {
                    $query
                        ->where(
                            'group_id',
                            $report->user->affiliation->group_id
                        )
                        ->orWhere('group_id', 1);
                });
        })
            ->where('approval_id', 3)
            ->get();

        foreach ($approvals as $approval) {
            if (
                $approval->approval_id == 2 &&
                $approval->affiliation->factory_id ==
                    $report->user->affiliation->factory_id &&
                ($approval->affiliation->department_id ==
                    $report->user->affiliation->department_id ||
                    $approval->affiliation->department_id == 1)
            ) {
                $report->approval1 = 1;
                // GLがいないとき工場長がGL承認する
                // これは申請時点で既に承認済みになるので必要ないが、
                // GLがいるときに申請してGL承認前にGLがいなくなったときのための処理
                if (empty($glApprovers->first())) {
                    $report->approval2 = 1;
                }
            } elseif (
                $approval->approval_id == 3 &&
                $approval->affiliation->factory_id ==
                    $report->user->affiliation->factory_id &&
                $approval->affiliation->department_id ==
                    $report->user->affiliation->department_id &&
                ($approval->affiliation->group_id ==
                    $report->user->affiliation->group_id ||
                    $approval->affiliation->group_id == 1)
            ) {
                $report->approval2 = 1;
            }
        }

        if ($report->approval1 == 1 && $report->approval2 == 1) {
            $report->approved = 1; # 承認
            DB::beginTransaction(); # トランザクション開始
            try {
                self::acquisitionSave($report);
                DB::commit(); # トランザクション成功終了
                $user = $report->user;
                $user->approved($report); # 届出作成者に承認を通知
                return redirect()
                    ->route('reports.show', $report)
                    ->with('notice', 'Approved');
            } catch (\Exception $e) {
                DB::rollBack(); # トランザクション失敗終了
                Log::error('Exception caught: ' . $e->getMessage());
                return back()->withErrors('エラーが発生しました');
            }
        } else {
            try {
                $report->save(); # 承認を保存
                return redirect()
                    ->route('reports.show', $report)
                    ->with('notice', 'Approved');
            } catch (\Throwable $th) {
                Log::error('Exception caught: ' . $th->getMessage());
                return back()->withErrors('エラーが発生しました');
            }
        }
    }

    # 承認取消
    // approvalCancel()
    public function approvalCancel(Report $report)
    {
        $approvals = Auth::user()->approvals->whereIn('approval_id', [2, 3]);
        $glApprovers = Approval::whereHas('affiliation', function (
            $query
        ) use ($report) {
            $query
                ->where('factory_id', $report->user->affiliation->factory_id)
                ->where(
                    'department_id',
                    $report->user->affiliation->department_id
                )
                ->where(function ($query) use ($report) {
                    $query
                        ->where(
                            'group_id',
                            $report->user->affiliation->group_id
                        )
                        ->orWhere('group_id', 1);
                });
        })
            ->where('approval_id', 3)
            ->get();

        foreach ($approvals as $approval) {
            if (
                $approval->approval_id == 2 &&
                $approval->affiliation->factory_id ==
                    $report->user->affiliation->factory_id &&
                ($approval->affiliation->department_id ==
                    $report->user->affiliation->department_id ||
                    $approval->affiliation->department_id == 1)
            ) {
                $report->approval1 = 0;
                if (empty($glApprovers->first())) {
                    $report->approval2 = 0;
                }
            } elseif (
                $approval->approval_id == 3 &&
                $approval->affiliation->factory_id ==
                    $report->user->affiliation->factory_id &&
                $approval->affiliation->department_id ==
                    $report->user->affiliation->department_id &&
                ($approval->affiliation->group_id ==
                    $report->user->affiliation->group_id ||
                    $approval->affiliation->group_id == 1)
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
                    return back()->withErrors('エラーが発生しました');
                }
            } elseif ($report->approved == 1) {
                DB::beginTransaction(); # トランザクション開始
                try {
                    self::acquisitionCancel($report);
                    DB::commit(); # トランザクション成功終了
                    $report_user->destroyReport($report); // 申請者に取消メール通知
                    // リダイレクト
                    return redirect()
                        ->route('reports.index')
                        ->with('notice', 'DestroyReport');
                } catch (\Exception $e) {
                    DB::rollBack(); # トランザクション失敗終了
                    // 例外情報をログに出力
                    Log::error('Exception caught: ' . $e->getMessage());
                    // エラー内容をそのまま表示しない
                    return back()->withErrors('エラーが発生しました');
                }
            }
        } else {
            try {
                $report->save(); # 取消確認を保存
                // 取消確認しました
                return redirect()
                    ->route('reports.show', $report)
                    ->with('notice', 'CheckedReport');
            } catch (\Throwable $th) {
                Log::error('Exception caught: ' . $th->getMessage());
                return back()->withErrors('エラーが発生しました');
            }
        }
    }

    /** 届出確定関数
     * reportを保存
     * acquisition_dayを更新
     * acquisitionを加算
     * remainingを減算
     */
    function acquisitionSave(Report $report)
    {
        $report->save();
        /**
         * // 有給休暇など残日数を管理する休暇に時間休を追加するときは、
         * // シフトの1日分の労働時間をオーバーしたところで日数を加算するプログラムをくむ
         * workHours,workMinutesはその時使用する
         * $work_hours = $report->shift_category->work_hours;
         * $work_minutes = $report->shift_category->work_minutes;
         */
        $acquisitionDay = AcquisitionDay::where('user_id', $report->user_id)
            ->where('report_id', $report->report_id)
            ->first();
        if (!empty($acquisitionDay)) {
            if ($report->sub_report_id == 3) {
                // 半日休は0.5日で格納
                $acquisitionDay->acquisition_days += 0.5;
                $acquisitionDay->remaining_days -= 0.5;
            } elseif ($report->sub_report_id == 4) {
                // 時間休は時間で取得だけ格納
                $acquisitionDay->acquisition_minutes +=
                    $report->acquisition_minutes;
                if ($acquisitionDay->acquisition_minutes > 60) {
                    // minutesからhoursに1時間繰上げ
                    $acquisitionDay->acquisition_minutes -= 60;
                    $acquisitionDay->acquisition_hours += 1;
                }
                $acquisitionDay->acquisition_hours +=
                    $report->acquisition_hours;
                // else {
            } else {
                if ($report->report_id <= 10) {
                    // 終日休、連休は日で格納
                    $acquisitionDay->remaining_days -=
                        $report->acquisition_days;
                    $acquisitionDay->acquisition_days +=
                        $report->acquisition_days;
                } else {
                    $acquisitionDay->acquisition_days +=
                        $report->acquisition_days;
                }

                /**
                 * // ここから下は有給休暇に時間休を追加するときに使用
                 * // のこり日数を登録
                 * $acquisitionDay->remaining_minutes -=
                 *     $report->acquisition_minutes;
                 * if ($acquisitionDay->remaining_minutes < 0) {
                 *     // hoursからminutesに1時間繰下げ
                 *     $acquisitionDay->remaining_hours -= 1;
                 *     $acquisitionDay->remaining_minutes += 60;
                 * }
                 *
                 * $acquisitionDay->remaining_hours -= $report->acquisition_hours;
                 * if ($acquisitionDay->remaining_hours < 0) {
                 *     // daysからhoursに1日繰下げ
                 *     $acquisitionDay->remaining_days -= 1;
                 *     $acquisitionDay->remaining_hours += $work_hours;
                 *     $acquisitionDay->remaining_minutes += $work_minutes;
                 * }
                 * $acquisitionDay->remaining_days -= $report->acquisition_days;
                 *
                 * 取得日数を登録
                 * $acquisitionDay->acquisition_minutes +=
                 *     $report->acquisition_minutes;
                 * if ($acquisitionDay->acquisition_minutes > 60) {
                 *     // minutesからhoursに1時間繰上げ
                 *     $acquisitionDay->acquisition_minutes -= 60;
                 *     $acquisitionDay->acquisition_hours += 1;
                 * }
                 *
                 * $acquisitionDay->acquisition_hours +=
                 *     $report->acquisition_hours;
                 * if (
                 *     $acquisitionDay->acquisition_hours > $work_hours ||
                 *     ($acquisitionDay->acquisition_hours == $work_hours &&
                 *         $acquisitionDay->acquisition_minutes == $work_minutes)
                 * ) {
                 *     // hoursからdaysに1日繰上げ
                 *     $acquisitionDay->acquisition_hours -= $work_hours;
                 *     $acquisitionDay->acquisition_minutes -= $work_minutes;
                 *     $acquisitionDay->acquisition_days += 1;
                 * }
                 * $acquisitionDay->acquisition_days += $report->acquisition_days;
                 */
            }
            $acquisitionDay->save(); # 残日数を保存
        }
    }

    /** 届出取消関数
     * reportを保存
     * acquisition_dayを更新
     * acquisitionを減算
     * remainingを加算
     */
    function acquisitionCancel(Report $report)
    {
        $report->save();
        $acquisitionDay = AcquisitionDay::where('user_id', $report->user_id)
            ->where('report_id', $report->report_id)
            ->first();
        if (!empty($acquisitionDay)) {
            if ($report->sub_report_id == 3) {
                // 半日休は0.5日で格納
                $acquisitionDay->acquisition_days -= 0.5;
                $acquisitionDay->remaining_days += 0.5;
            } elseif ($report->sub_report_id == 4) {
                // 時間休は時間で取得だけ格納
                $acquisitionDay->acquisition_minutes -=
                    $report->acquisition_minutes;
                if ($acquisitionDay->acquisition_minutes < 0) {
                    // minutesからhoursに1時間繰下げ
                    $acquisitionDay->acquisition_minutes += 60;
                    $acquisitionDay->acquisition_hours -= 1;
                }
                $acquisitionDay->acquisition_hours -=
                    $report->acquisition_hours;
            } else {
                // 終日休、連休は日で格納
                $acquisitionDay->remaining_days += $report->acquisition_days;
                $acquisitionDay->acquisition_days -= $report->acquisition_days;
            }
            $acquisitionDay->save(); # 残日数を保存
        }
        $report->delete();
    }

    // menu()
    public function menu()
    {
        $approvals = Auth::user()->approvals->load('affiliation');
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
                                            $approval->affiliation->factory_id
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
            ->acquisition_days->where('report_id', 1)
            ->first();

        return view('menu.index')->with(
            compact(
                'pending',
                'approved',
                'paid_holidays',
                'birthday',
                'year_end'
            )
        );
    }

    // exportForm
    public function exportForm()
    {
        $approvals = Auth::user()
            ->approvals->where('approval_id', '!=', 1)
            ->load('affiliation');
        // 権限に当てはまるユーザーの申請を取得
        $reports = Report::whereHas('user.affiliation', function ($query) use (
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
                        } elseif (
                            $approval->affiliation->department_id != 1 &&
                            $approval->affiliation->group_id == 1
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
                        } elseif (
                            $approval->affiliation->department_id != 1 &&
                            $approval->affiliation->group_id != 1
                        ) {
                            $query
                                ->where(
                                    'factory_id',
                                    $approval->affiliation->factory_id
                                )
                                ->where(
                                    'department_id',
                                    $approval->affiliation->department_id
                                )
                                ->where(
                                    'group_id',
                                    $approval->affiliation->group_id
                                );
                        }
                    });
                }
                // 工場長を追加
                $query->orWhere(function ($query) use ($approval) {
                    $query
                        ->where(
                            'factory_id',
                            $approval->affiliation->factory_id
                        )
                        ->where('department_id', 1);
                });
            });
        })
            ->where('approved', 1)
            ->where('cancel', 0)
            ->get();

        // 全体の閲覧権限があるときは全てのレポートを取得
        if ($approvals->contains('affiliation_id', 1)) {
            $reports = Report::where('approved', 1)
                ->where('cancel', 0)
                ->get();
        }

        # 重複削除&並べ替え
        if ($reports->first()) {
            $reports = $reports
                ->unique()
                ->load([
                    'user.affiliation.factory',
                    'user.affiliation.department',
                    'user.affiliation.group',
                    'report_category',
                    'shift_category',
                    'reason_category',
                    'sub_report_category',
                ])
                ->sortBy('report_id')
                ->sortBy('user.affiliation_id')
                ->sortByDesc('start_date')
                ->sortByDesc('report_date');
        }

        // ページ番号と1ページあたりのアイテム数を指定
        $page = request()->get('page', 1); // 現在のページ番号を取得、デフォルトは1
        $perPage = 25; // 1ページあたりのアイテム数を設定

        // コレクションをページネーションする
        $paginator = new LengthAwarePaginator(
            $reports->forPage($page, $perPage), // ページに表示するアイテムを取得
            $reports->count(), // 全体のアイテム数
            $perPage, // 1ページあたりのアイテム数
            $page, // 現在のページ番号
            ['path' => request()->url()] // ページネーションリンクのURLを指定
        );

        $affiliations = Affiliation::all()->load([
            'factory',
            'department',
            'group',
        ]);
        $reportCategories = ReportCategory::all();
        $reasonCategories = ReasonCategory::all();
        $users = User::all('id', 'employee');

        // sessionリセット
        Session::forget('reports_collection');
        // sessionにreportsを保存
        Session::put('reports_collection', $reports);

        return view('reports.export_form')->with(
            compact(
                'paginator',
                'affiliations',
                'reportCategories',
                'reasonCategories',
                'users'
            )
        );
    }

    // export_search
    public function exportSearch(Request $request)
    {
        // 管理者権限は設定についての権限なので、一覧に影響しない
        $approvals = Auth::user()
            ->approvals->where('approval_id', '!=', 1)
            ->load('affiliation');
        // 権限に当てはまるユーザーの申請を取得
        $reports = Report::whereHas('user.affiliation', function ($query) use (
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
                        } elseif (
                            $approval->affiliation->department_id != 1 &&
                            $approval->affiliation->group_id == 1
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
                        } elseif (
                            $approval->affiliation->department_id != 1 &&
                            $approval->affiliation->group_id != 1
                        ) {
                            $query
                                ->where(
                                    'factory_id',
                                    $approval->affiliation->factory_id
                                )
                                ->where(
                                    'department_id',
                                    $approval->affiliation->department_id
                                )
                                ->where(
                                    'group_id',
                                    $approval->affiliation->group_id
                                );
                        }
                    });
                }
                // 工場長を追加
                $query->orWhere(function ($query) use ($approval) {
                    $query
                        ->where(
                            'factory_id',
                            $approval->affiliation->factory_id
                        )
                        ->where('department_id', 1);
                });
            });
        })
            ->where('approved', 1)
            ->where('cancel', 0)
            ->get();

        // 全体の閲覧権限があるときは全てのレポートを取得
        if ($approvals->contains('affiliation_id', 1)) {
            $reports = Report::where('approved', 1)
                ->where('cancel', 0)
                ->get();
        }

        # 重複削除&並べ替え
        if ($reports->first()) {
            $reports = $reports
                ->unique()
                ->load([
                    'user.affiliation',
                    'user.affiliation.factory',
                    'user.affiliation.department',
                    'user.affiliation.group',
                    'report_category',
                    'shift_category',
                    'sub_report_category',
                    'reason_category',
                ])
                ->sortBy('report_id')
                ->sortBy('user.affiliation_id')
                ->sortBy('start_date')
                ->sortByDesc('start_date')
                ->sortByDesc('report_date');
        }

        $affiliationId = $request->select_affiliation;
        $reason_id = $request->select_reason;
        $reportId = $request->select_report;
        $month = $request->select_month;
        $affiliation = Affiliation::find($affiliationId);

        # monthから月初め日、月終わり日を定義
        if ($month) {
            $carbon = new Carbon($month);
            $startDate = $carbon->format('Y-m-d');
            $endDate = $carbon
                ->addMonth()
                ->subDay()
                ->format('Y-m-d');
        }

        /** 条件に従って帳票出力するreportを取得 */
        if ($affiliationId == 1) {
            if ($reportId != null && $reason_id == null && $month == null) {
                # 休暇種類を指定
                $reports = $reports->where('report_id', $reportId);
            } elseif (
                $reportId == null &&
                $reason_id != null &&
                $month == null
            ) {
                # 理由を指定
                $reports = $reports->where('reason_id', $reason_id);
            } elseif (
                $reportId == null &&
                $reason_id == null &&
                $month != null
            ) {
                # 月を指定
                $reports = $reports
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate);
            } elseif (
                $reportId != null &&
                $reason_id != null &&
                $month == null
            ) {
                # 休暇種類,理由を指定
                $reports = $reports
                    ->where('report_id', $reportId)
                    ->where('reason_id', $reason_id);
            } elseif (
                $reportId != null &&
                $reason_id == null &&
                $month != null
            ) {
                # 休暇種類,月を指定
                $reports = $reports
                    ->where('report_id', $reportId)
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate);
            } elseif (
                $reportId == null &&
                $reason_id != null &&
                $month != null
            ) {
                # 理由,月を指定
                $reports = $reports
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate)
                    ->where('reason_id', $reason_id);
            } elseif (
                $reportId != null &&
                $reason_id != null &&
                $month != null
            ) {
                # 休暇種類,理由,月を指定
                $reports = $reports
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate)
                    ->where('report_id', $reportId)
                    ->where('reason_id', $reason_id);
            }
        } else {
            if (
                $affiliationId != null &&
                $reportId == null &&
                $reason_id == null &&
                $month == null
            ) {
                # 所属を指定
                $reports = $reports->filter(function ($item) use (
                    $affiliationId,
                    $affiliation
                ) {
                    if ($affiliation->department_id == 1) {
                        return $item->user->affiliation->factory_id ==
                            $affiliation->factory_id;
                    } elseif (
                        $affiliation->department_id != 1 &&
                        $affiliation->group_id == 1
                    ) {
                        return $item->user->affiliation->factory_id ==
                            $affiliation->factory_id &&
                            $item->user->affiliation->department_id ==
                                $affiliation->department_id;
                    } else {
                        return $item->user->affiliation_id == $affiliationId;
                    }
                });
            } elseif (
                $affiliationId == null &&
                $reportId != null &&
                $reason_id == null &&
                $month == null
            ) {
                # 休暇種類を指定
                $reports = $reports->where('report_id', $reportId);
            } elseif (
                $affiliationId == null &&
                $reportId == null &&
                $reason_id != null &&
                $month == null
            ) {
                # 理由を指定
                $reports = $reports->where('reason_id', $reason_id);
            } elseif (
                $affiliationId == null &&
                $reportId == null &&
                $reason_id == null &&
                $month != null
            ) {
                # 月を指定
                $reports = $reports
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate);
            } elseif (
                $affiliationId != null &&
                $reportId != null &&
                $reason_id == null &&
                $month == null
            ) {
                # 所属,休暇種類を指定
                $reports = $reports
                    ->filter(function ($item) use (
                        $affiliationId,
                        $affiliation
                    ) {
                        if ($affiliation->department_id == 1) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id;
                        } elseif (
                            $affiliation->department_id != 1 &&
                            $affiliation->group_id == 1
                        ) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id &&
                                $item->user->affiliation->department_id ==
                                    $affiliation->department_id;
                        } else {
                            return $item->user->affiliation_id ==
                                $affiliationId;
                        }
                    })
                    ->where('report_id', $reportId);
            } elseif (
                $affiliationId != null &&
                $reportId == null &&
                $reason_id != null &&
                $month == null
            ) {
                # 所属,理由を指定
                $reports = $reports
                    ->filter(function ($item) use (
                        $affiliationId,
                        $affiliation
                    ) {
                        if ($affiliation->department_id == 1) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id;
                        } elseif (
                            $affiliation->department_id != 1 &&
                            $affiliation->group_id == 1
                        ) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id &&
                                $item->user->affiliation->department_id ==
                                    $affiliation->department_id;
                        } else {
                            return $item->user->affiliation_id ==
                                $affiliationId;
                        }
                    })
                    ->where('reason_id', $reason_id);
            } elseif (
                $affiliationId != null &&
                $reportId == null &&
                $reason_id == null &&
                $month != null
            ) {
                # 所属,月を指定
                $reports = $reports
                    ->filter(function ($item) use (
                        $affiliationId,
                        $affiliation
                    ) {
                        if ($affiliation->department_id == 1) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id;
                        } elseif (
                            $affiliation->department_id != 1 &&
                            $affiliation->group_id == 1
                        ) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id &&
                                $item->user->affiliation->department_id ==
                                    $affiliation->department_id;
                        } else {
                            return $item->user->affiliation_id ==
                                $affiliationId;
                        }
                    })
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate);
            } elseif (
                $affiliationId == null &&
                $reportId != null &&
                $reason_id != null &&
                $month == null
            ) {
                # 休暇種類,理由を指定
                $reports = $reports
                    ->where('report_id', $reportId)
                    ->where('reason_id', $reason_id);
            } elseif (
                $affiliationId == null &&
                $reportId != null &&
                $reason_id == null &&
                $month != null
            ) {
                # 休暇種類,月を指定
                $reports = $reports
                    ->where('report_id', $reportId)
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate);
            } elseif (
                $affiliationId == null &&
                $reportId == null &&
                $reason_id != null &&
                $month != null
            ) {
                # 理由,月を指定
                $reports = $reports
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate)
                    ->where('reason_id', $reason_id);
            } elseif (
                $affiliationId != null &&
                $reportId != null &&
                $reason_id != null &&
                $month == null
            ) {
                # 所属,休暇種類,理由を指定
                $reports = $reports
                    ->filter(function ($item) use (
                        $affiliationId,
                        $affiliation
                    ) {
                        if ($affiliation->department_id == 1) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id;
                        } elseif (
                            $affiliation->department_id != 1 &&
                            $affiliation->group_id == 1
                        ) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id &&
                                $item->user->affiliation->department_id ==
                                    $affiliation->department_id;
                        } else {
                            return $item->user->affiliation_id ==
                                $affiliationId;
                        }
                    })
                    ->where('report_id', $reportId)
                    ->where('reason_id', $reason_id);
            } elseif (
                $affiliationId != null &&
                $reportId != null &&
                $reason_id == null &&
                $month != null
            ) {
                # 所属,休暇種類,月を指定
                $reports = $reports
                    ->filter(function ($item) use (
                        $affiliationId,
                        $affiliation
                    ) {
                        if ($affiliation->department_id == 1) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id;
                        } elseif (
                            $affiliation->department_id != 1 &&
                            $affiliation->group_id == 1
                        ) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id &&
                                $item->user->affiliation->department_id ==
                                    $affiliation->department_id;
                        } else {
                            return $item->user->affiliation_id ==
                                $affiliationId;
                        }
                    })
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate)
                    ->where('report_id', $reportId);
            } elseif (
                $affiliationId != null &&
                $reportId == null &&
                $reason_id != null &&
                $month != null
            ) {
                # 所属,理由,月を指定
                $reports = $reports
                    ->filter(function ($item) use (
                        $affiliationId,
                        $affiliation
                    ) {
                        if ($affiliation->department_id == 1) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id;
                        } elseif (
                            $affiliation->department_id != 1 &&
                            $affiliation->group_id == 1
                        ) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id &&
                                $item->user->affiliation->department_id ==
                                    $affiliation->department_id;
                        } else {
                            return $item->user->affiliation_id ==
                                $affiliationId;
                        }
                    })
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate)
                    ->where('reason_id', $reason_id);
            } elseif (
                $affiliationId == null &&
                $reportId != null &&
                $reason_id != null &&
                $month != null
            ) {
                # 休暇種類,理由,月を指定
                $reports = $reports
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate)
                    ->where('report_id', $reportId)
                    ->where('reason_id', $reason_id);
            } elseif (
                $affiliationId != null &&
                $reportId != null &&
                $reason_id != null &&
                $month != null
            ) {
                # すべて指定
                $reports = $reports
                    ->filter(function ($item) use (
                        $affiliationId,
                        $affiliation
                    ) {
                        if ($affiliation->department_id == 1) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id;
                        } elseif (
                            $affiliation->department_id != 1 &&
                            $affiliation->group_id == 1
                        ) {
                            return $item->user->affiliation->factory_id ==
                                $affiliation->factory_id &&
                                $item->user->affiliation->department_id ==
                                    $affiliation->department_id;
                        } else {
                            return $item->user->affiliation_id ==
                                $affiliationId;
                        }
                    })
                    ->where('report_id', $reportId)
                    ->where('reason_id', $reason_id)
                    ->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate);
            }
        }

        // ページ番号と1ページあたりのアイテム数を指定
        $page = request()->get('page', 1); // 現在のページ番号を取得、デフォルトは1
        $perPage = 25; // 1ページあたりのアイテム数を設定

        // コレクションをページネーションする
        $paginator = new LengthAwarePaginator(
            $reports->forPage($page, $perPage), // ページに表示するアイテムを取得
            $reports->count(), // 全体のアイテム数
            $perPage, // 1ページあたりのアイテム数
            $page, // 現在のページ番号
            ['path' => request()->url()] // ページネーションリンクのURLを指定
        );

        $affiliations = Affiliation::all()->load([
            'factory',
            'department',
            'group',
        ]);
        $reportCategories = ReportCategory::all();
        $reasonCategories = ReasonCategory::all();
        $users = User::all('id', 'employee', 'name')->sortBy('employee');

        // sessionリセット
        Session::forget('reports_collection');
        // sessionにreportsを保存
        Session::put('reports_collection', $reports);

        return view('reports.export_form')->with(
            compact(
                'paginator',
                'affiliations',
                'reportCategories',
                'reasonCategories',
                'users'
            )
        );
    }

    // export()
    public function export()
    {
        $reports = Session::get('reports_collection');

        $view = view('reports.export')->with(compact('reports'));
        return Excel::download(new ReportFormExport($view), 'reports.xlsx');
    }

    public function import(Request $request)
    {
        $excel_file = $request->file('excel_file');
        $excel_file->store('excels');
        Excel::import(new ReportImport(), $excel_file);

        return redirect()
            ->route('import_form')
            ->with('notice', '申請インポート完了！');
    }

    public function allExport()
    {
        # 全データ出力
        return Excel::download(new MultipleExport(), 'pp.xlsx');
    }

    function monitor()
    {
        $pending_reports = Report::with('user')
            ->where('approved', 0)
            ->where('cancel', 0)
            ->get()
            ->load([
                'user',
                'user.affiliation',
                'user.affiliation.factory',
                'user.affiliation.department',
                'user.affiliation.group',
            ])
            ->groupBy('user.affiliation.id')
            ->map(function ($query) {
                return [
                    'affiliation' => $query->first()->user->affiliation_name,
                    'count' => $query->count(),
                ];
            });
        return view('reports.monitor')->with(compact('pending_reports'));
    }
}
