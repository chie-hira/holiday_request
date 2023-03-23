<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\Limit;
use App\Models\ReasonCategory;
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
        $own_limits = Limit::all()->where('user_id', '=', Auth::id());
        // dd($own_limits);
        return view('reports.create')->with(
            compact('report_categories', 'reasons', 'own_limits')
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

        try {
            $report->save();
            return redirect(route('reports.index'))
                ->with('notice', '提出しました');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->withErrors($th->getMessage())->withInput();
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
        //
    }
}
