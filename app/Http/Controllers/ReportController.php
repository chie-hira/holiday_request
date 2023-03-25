<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\Limit;
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
        $reports = Report::all();

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
        // dd($own_limits);
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
        if ($request->reason_id == 1) {
            $request->validate(
                [
                    'start_date' => 'required|date',
                    'end_date' => 'required|date|after:start_date',
                ],
            );
        }
        if ($request->reason_id == 7) {
            $request->validate(
                [
                    'report_detail' => 'required|max:200',
                ],
                [
                    'report_detail.required' => '理由は必須です。',
                ]
            );
        }

        $report = new Report();
        $report->fill($request->all());

        $report_id = $report->report_id;
        if ($report_id == 2 || $report_id ==3) {
            $report_id = 1;
        }
        $remaining = Remaining::where('user_id', '=', $request->user_id)
            ->where('report_id', '=', $report_id)
            ->first();
        $remaining->remaining = $request->remaining;

        try {
            $report->save();
            $remaining->save();
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
        //
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
                ->route('male_pigs.index')
                ->with('notice', '届けを取り消しました');
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }
}
