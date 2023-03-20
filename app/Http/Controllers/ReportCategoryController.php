<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportCategoryRequest;
use App\Http\Requests\UpdateReportCategoryRequest;
use App\Models\ReportCategory;

class ReportCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReportCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReportCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReportCategory  $reportCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ReportCategory $reportCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReportCategory  $reportCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportCategory $reportCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReportCategoryRequest  $request
     * @param  \App\Models\ReportCategory  $reportCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReportCategoryRequest $request, ReportCategory $reportCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReportCategory  $reportCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportCategory $reportCategory)
    {
        //
    }
}
