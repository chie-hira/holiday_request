<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\ReasonCategory;
use App\Models\Remaining;
use App\Models\Report;
use App\Models\ReportCategory;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

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
        $reasons = ReasonCategory::all();
        $own_remainings = Remaining::all()->where('user_id', '=', Auth::id());

        if (empty($own_remainings->first())) {
            $report_ids = [1, 4, 5, 7, 8, 9, 10, 16];
            foreach ($report_ids as $report_id) {
                self::newRemaining($report_id);
            }
            $own_remainings = Remaining::all()->where(
                'user_id',
                '=',
                Auth::id()
            );
        }

        return view('reports.create')->with(
            compact('report_categories', 'reasons', 'own_remainings')
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
        if ($request->report_id == 1) {
            $request->validate([
                'start_date' => 'required|date|after_or_equal:report_date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);
        }
        if ($request->report_id == 2) {
            $request->validate([
                'start_date' => 'required|date|after_or_equal:report_date',
            ]);
        }
        if ($request->report_id == 3) {
            $request->validate(
                [
                    'start_time' => 'required|date_format:H:i',
                    'end_time' => 'required|date_format:H:i|after:start_time',
                    'get_days' => 'required|multiple_of:0.125',
                ],
                [
                    'get_days.multiple_of' =>
                        '時間休は1時間単位で取得可能です。',
                ]
            );
        }
        if ($request->report_id == 13 || $request->report_id == 14) {
            // $m = [
            //     0.02083, 0.04167, 0.0625, 0.08333, 0.10417
            // ];
            // if (in_array($request->get_days, $m)) {
            //     $request->validate(
            //         [
            //             'start_time' => 'required|date_format:H:i',
            //             'end_time' => 'required|date_format:H:i|after:start_time',
            //             'get_days' => 'required',
            //         ],
            //     );
            // } else {
                $request->validate(
                    [
                        'start_time' => 'required|date_format:H:i',
                        'end_time' => 'required|date_format:H:i|after:start_time',
                        // 'get_days' => 'required|multiple_of:0.02083',
                        // FIXME:
                        'get_days' => ['required', Rule::in([0.02083, 0.04167, 0.0625, 0.08333, 0.10417, 0.125,
                                                            0.14583, 0.16667, 0.1875, 0.20833, 0.22917, 0.25,
                                                            0.27083, 0.29167, 0.3125, 0.33333, 0.35417, 0.375,
                                                            0.39583, 0.41667, 0.4375, 0.45833, 0.47917, 0.50,
                                                            0.52083, 0.54167, 0.5625, 0.58333, 0.60417, 0.625,
                                                            0.64583, 0.66667, 0.6875, 0.70833, 0.72917, 0.75,
                                                            0.77083, 0.79167, 0.8125, 0.83333, 0.85417, 0.825,
                                                            0.89583, 0.91667, 0.9375, 0.95833, 0.97917, 
                                                            ])],
                    ],
                    [
                        'get_days.multiple_of' =>
                            '遅刻・早退は10分単位で取得可能です。',
                    ]
                );
            // }
        }
        if ($request->report_id == 15) {
            $request->validate(
                [
                    'start_time' => 'required|date_format:H:i',
                    'end_time' => 'required|date_format:H:i|after:start_time',
                    'get_days' => 'required|multiple_of:0.0625',
                ],
                [
                    'get_days.multiple_of' => '外出は30分単位で取得可能です。',
                ]
            );
        }
        if ($request->reason_id == 8) {
            $request->validate(
                [
                    'reason_detail' => 'required|max:200',
                ],
                [
                    'reason_detail.required' => '理由は必須です。',
                ]
            );
        }

        $report_id = $request->report_id;
        if ($report_id == 2 || $report_id == 3) {
            $report_id = 1;
        }
        $remaining = Remaining::where('user_id', '=', Auth::user()->id)
            ->where('report_id', '=', $report_id)
            ->first('remaining');
        if (!empty($remaining->remaining)) {
            $result = $remaining->remaining - $request->get_days;

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
        // dd(empty(Auth::user()->approvals->where('approval_id', '=', 1)->first()));
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
        $reasons = ReasonCategory::all();
        $own_remainings = Remaining::all()->where('user_id', '=', Auth::id());

        return view('reports.edit')->with(
            compact('report', 'report_categories', 'reasons', 'own_remainings')
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
        if ($request->report_id == 1) {
            $request->validate([
                'start_date' => 'required|date|after_or_equal:report_date',
                'end_date' => 'required|date|after:start_date',
            ]);
        }
        if ($request->report_id == 2) {
            $request->validate([
                'start_date' => 'required|date|after_or_equal:report_date',
            ]);
        }
        if ($request->report_id == 3) {
            $request->validate(
                [
                    'start_time' => 'required|date_format:H:i',
                    'end_time' => 'required|date_format:H:i|after:start_time',
                    'get_days' => 'required|multiple_of:0.125',
                ],
                [
                    'get_days.multiple_of' =>
                        '時間休は1時間単位で取得可能です。',
                ]
            );
        }
        if ($request->report_id == 12 || $request->report_id == 13) {
            $request->validate(
                [
                    'start_time' => 'required|date_format:H:i',
                    'end_time' => 'required|date_format:H:i|after:start_time',
                    'get_days' => 'required|multiple_of:0.02083',
                ],
                [
                    'get_days.multiple_of' =>
                        '遅刻・早退は10分単位で取得可能です。',
                ]
            );
        }
        if ($request->report_id == 14) {
            $request->validate(
                [
                    'start_time' => 'required|date_format:H:i',
                    'end_time' => 'required|date_format:H:i|after:start_time',
                    'get_days' => 'required|multiple_of:0.0625',
                ],
                [
                    'get_days.multiple_of' => '外出は30分単位で取得可能です。',
                ]
            );
        }
        if ($request->reason_id == 7) {
            $request->validate(
                [
                    'reason_detail' => 'required|max:200',
                ],
                [
                    'reason_detail.required' => '理由は必須です。',
                ]
            );
        }

        $report_id = $request->report_id;
        if ($report_id == 2 || $report_id == 3) {
            $report_id = 1;
        }
        $remaining = Remaining::where('user_id', '=', Auth::user()->id)
            ->where('report_id', '=', $report_id)
            ->first('remaining');
        if ($remaining) {
            $result = $remaining->remaining - $request->get_days;

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

    public function approvalPending()
    {
        $user = Auth::user();
        if (!empty(Auth::user()->approvals->where('approval_id', '=', 1)->first())) {
            $reports = Report::where('approval1', '=', 0)
                ->orWhere('approval2', '=', 0)
                ->orWhere('approval3', '=', 0)
                ->get();
        } 

        if (!empty(Auth::user()->approvals->where('approval_id', '=', 2)->first())) {
            $reports = new Collection();
            foreach ($user->approvals as $approval) {
                $extractions = Report::whereHas('user', function ($query) use ($approval) {
                    $query->where('factory_id', $approval->factory_id);
                })
                ->where(function ($query)
                {
                    $query->where('approval1', '=', 0)
                    ->orWhere('approval2', '=', 0)
                    ->orWhere('approval3', '=', 0);
                })
                ->get();

                $extractions->each(function ($extraction) use ($reports)
                {
                    $reports->add($extraction);
                });
            }
        }

        if (!empty(Auth::user()->approvals->where('approval_id', '=', 3)->first())) {
            $reports = new Collection();
            foreach ($user->approvals as $approval) {
                $extractions = Report::whereHas('user', function ($query) use ($approval) {
                    $query->where('factory_id', $approval->factory_id)
                        ->where('department_id', $approval->department_id);
                })
                ->where(function ($query)
                {
                    $query->where('approval1', '=', 0)
                    ->orWhere('approval2', '=', 0)
                    ->orWhere('approval3', '=', 0);
                })
                ->get();

                $extractions->each(function ($extraction) use ($reports)
                {
                    $reports->add($extraction);
                });
            }
        }
        return view('approvals.pending')->with(compact('reports'));
    }

    public function approved()
    {
        $user = Auth::user();
        if (!empty(Auth::user()->approvals->where('approval_id', '=', 1)->first())) {
            $reports = Report::where('approval1', '=', 1)
                ->where('approval2', '=', 1)
                ->where('approval3', '=', 1)
                ->get();
        } 

        if (!empty(Auth::user()->approvals->where('approval_id', '=', 2)->first())) {
            $reports = new Collection();
            foreach ($user->approvals as $approval) {
                $extractions = Report::whereHas('user', function ($query) use ($approval) {
                    $query->where('factory_id', $approval->factory_id);
                })
                ->where(function ($query)
                {
                    $query->where('approval1', '=', 1)
                    ->where('approval2', '=', 1)
                    ->where('approval3', '=', 1);
                })
                ->get();

                $extractions->each(function ($extraction) use ($reports)
                {
                    $reports->add($extraction);
                });
            }
        }

        if (!empty(Auth::user()->approvals->where('approval_id', '=', 3)->first())) {
            $reports = new Collection();
            foreach ($user->approvals as $approval) {
                $extractions = Report::whereHas('user', function ($query) use ($approval) {
                    $query->where('factory_id', $approval->factory_id)
                        ->where('department_id', $approval->department_id);
                })
                ->where(function ($query)
                {
                    $query->where('approval1', '=', 1)
                    ->where('approval2', '=', 1)
                    ->where('approval3', '=', 1);
                })
                ->get();

                $extractions->each(function ($extraction) use ($reports)
                {
                    $reports->add($extraction);
                });
            }
        }
        return view('approvals.index')->with(compact('reports'));
    }

    public function approvalList()
    {
        // $users = User::with(['reports', 'remainings'])
        //     ->withCount([
        //         'reports AS sum_get_days' => function ($query){
        //             $query->where([
        //                 ['report_id', '=', 2],
        //                 ['approval1', '=', 1],
        //                 ['approval2', '=', 1],
        //                 ['approval3', '=', 1],
        //             ])
        //             ->select(DB::raw('SUM(get_days) as sum_get_days'));
        //         },
        //     ])
        //     ->get();

        $users = User::with(['reports', 'remainings'])->get();
        $report_categories = ReportCategory::all();
        return view('approvals.list')->with(compact('users', 'report_categories'));
    }

    public function approval(Report $report)
    {
        if (!empty(Auth::user()->approvals->where('approval_id', '=', 1)->first())) {
            $report->approval1 = 1;
        }
        // FIXME:2権限、3権限を持つuserがいたら誤作動
        if (!empty(Auth::user()->approvals->where('approval_id', '=', 2)->first())) {
            $report->approval2 = 1;
        }

        if (!empty(Auth::user()->approvals->where('approval_id', '=', 3)->first())) {
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
            if ($report_id == 2 || $report_id == 3) {
                $report_id = 1;
            }
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

        return view('reports.show')->with(compact('report'))->with('notice', '承認しました');
    }
}
