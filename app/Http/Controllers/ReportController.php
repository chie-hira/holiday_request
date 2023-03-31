<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\ReasonCategory;
use App\Models\Remaining;
use App\Models\Report;
use App\Models\ReportCategory;
use Illuminate\Support\Facades\Auth;

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

    public function all_index()
    {
        $reports = Report::all();

        return view('reports.all_index')->with(compact('reports'));
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
            $report_ids = [1, 4, 5, 6, 7, 8, 9, 15];
            // $report_ids = [1, 4, 5, 6, 7, 8, 9, 10, 15, 17];
            foreach ($report_ids as $report_id) {
                self::newRemaining($report_id);
            }
            $own_remainings = Remaining::all()->where(
                'user_id',
                '==',
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
        // dd($request);
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
                    // 'get_days' => 'required|multiple_of:0.125',
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

        # reportsレコード作成
        $report = new Report();
        $report->fill($request->all());

        // $report_id = $report->report_id;
        // if ($report_id == 2 || $report_id ==3) {
        //     $report_id = 1;
        // }

        // # remainingsレコード更新
        // $remaining = Remaining::where('user_id', '=', $request->user_id)
        //     ->where('report_id', '=', $report_id)
        //     ->first();
        // if (!empty($remaining)) {
        //     $remaining->remaining = $request->remaining;
        // }

        try {
            $report->save();
            // if (!empty($remaining)) {
            //     $remaining->save();
            // }
            return redirect(route('reports.index'))->with(
                'notice',
                '提出しました'
            );
        } catch (\Throwable $th) {
            //throw $th;
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
        //
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

    public function allApprovalPending()
    {
        $reports = Report::where('approval1', '=', 0)
            ->orWhere('approval2', '=', 0)
            ->orWhere('approval3', '=', 0)
            ->get();
        // dd($reports);
        return view('approvals.all_index')->with(compact('reports'));
    }

    public function approvalPending()
    {
        $reports = Report::where('user_id', '=', Auth::user()->id)->where(
            function ($query) {
                $query
                    ->where('approval1', '=', 0)
                    ->orWhere('approval2', '=', 0)
                    ->orWhere('approval2', '=', 0);
            }
        )
        ->get();
        // ->Where('approval1', '=', 0)
        // ->orWhere('approval2', '=', 0)
        // ->orWhere('approval3', '=', 0);
        // dd($reports);
        return view('approvals.index')->with(compact('reports'));
    }

    public function approval1(Report $report)
    {
        $report->approval1 = 1;

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
            $report->save();
            if (!empty($remaining)) {
                $remaining->save();
            }
            return redirect()
                ->route('reports.show')
                ->with(compact('report'))
                ->with('notice', '承認しました');
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }

    public function approval2(Report $report)
    {
        $report->approval2 = 1;

        try {
            $report->save();
            return redirect()
                ->route('reports.show')
                ->with(compact('report'))
                ->with('notice', '承認しました');
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }

    public function approval3(Report $report)
    {
        $report->approval3 = 1;

        try {
            $report->save();
            return redirect()
                ->route('reports.show')
                ->with(compact('report'))
                ->with('notice', '承認しました');
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }
}
