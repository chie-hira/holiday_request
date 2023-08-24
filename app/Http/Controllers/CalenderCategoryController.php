<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCalenderCategoryRequest;
use App\Http\Requests\UpdateCalenderCategoryRequest;
use App\Models\CalenderCategory;

class CalenderCategoryController extends Controller
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
     * @param  \App\Http\Requests\StoreCalenderCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCalenderCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CalenderCategory  $calenderCategory
     * @return \Illuminate\Http\Response
     */
    public function show(CalenderCategory $calenderCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CalenderCategory  $calenderCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(CalenderCategory $calenderCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCalenderCategoryRequest  $request
     * @param  \App\Models\CalenderCategory  $calenderCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCalenderCategoryRequest $request, CalenderCategory $calenderCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CalenderCategory  $calenderCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(CalenderCategory $calenderCategory)
    {
        //
    }
}
