<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentCategoryRequest;
use App\Http\Requests\UpdateDepartmentCategoryRequest;
use App\Models\DepartmentCategory;

class DepartmentCategoryController extends Controller
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
     * @param  \App\Http\Requests\StoreDepartmentCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartmentCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DepartmentCategory  $departmentCategory
     * @return \Illuminate\Http\Response
     */
    public function show(DepartmentCategory $departmentCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DepartmentCategory  $departmentCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(DepartmentCategory $departmentCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDepartmentCategoryRequest  $request
     * @param  \App\Models\DepartmentCategory  $departmentCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartmentCategoryRequest $request, DepartmentCategory $departmentCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DepartmentCategory  $departmentCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(DepartmentCategory $departmentCategory)
    {
        //
    }
}
