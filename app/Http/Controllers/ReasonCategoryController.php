<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReasonCategoryRequest;
use App\Http\Requests\UpdateReasonCategoryRequest;
use App\Models\ReasonCategory;

class ReasonCategoryController extends Controller
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
     * @param  \App\Http\Requests\StoreReasonCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReasonCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReasonCategory  $reasonCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ReasonCategory $reasonCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReasonCategory  $reasonCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ReasonCategory $reasonCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReasonCategoryRequest  $request
     * @param  \App\Models\ReasonCategory  $reasonCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReasonCategoryRequest $request, ReasonCategory $reasonCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReasonCategory  $reasonCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReasonCategory $reasonCategory)
    {
        //
    }
}
