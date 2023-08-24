<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDateCategoryRequest;
use App\Http\Requests\UpdateDateCategoryRequest;
use App\Models\DateCategory;

class DateCategoryController extends Controller
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
     * @param  \App\Http\Requests\StoreDateCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDateCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DateCategory  $dateCategory
     * @return \Illuminate\Http\Response
     */
    public function show(DateCategory $dateCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DateCategory  $dateCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(DateCategory $dateCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDateCategoryRequest  $request
     * @param  \App\Models\DateCategory  $dateCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDateCategoryRequest $request, DateCategory $dateCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DateCategory  $dateCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(DateCategory $dateCategory)
    {
        //
    }
}
