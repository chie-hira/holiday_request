<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShiftCategoryRequest;
use App\Http\Requests\UpdateShiftCategoryRequest;
use App\Models\ShiftCategory;

class ShiftCategoryController extends Controller
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
     * @param  \App\Http\Requests\StoreShiftCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShiftCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShiftCategory  $shiftCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ShiftCategory $shiftCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShiftCategory  $shiftCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ShiftCategory $shiftCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateShiftCategoryRequest  $request
     * @param  \App\Models\ShiftCategory  $shiftCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateShiftCategoryRequest $request, ShiftCategory $shiftCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShiftCategory  $shiftCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShiftCategory $shiftCategory)
    {
        //
    }
}
