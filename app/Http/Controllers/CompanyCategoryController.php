<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyCategoryRequest;
use App\Http\Requests\UpdateCompanyCategoryRequest;
use App\Models\CompanyCategory;

class CompanyCategoryController extends Controller
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
     * @param  \App\Http\Requests\StoreCompanyCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CompanyCategory  $companyCategory
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyCategory $companyCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompanyCategory  $companyCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanyCategory $companyCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCompanyCategoryRequest  $request
     * @param  \App\Models\CompanyCategory  $companyCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyCategoryRequest $request, CompanyCategory $companyCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompanyCategory  $companyCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyCategory $companyCategory)
    {
        //
    }
}
