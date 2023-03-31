<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFactoryCategoryRequest;
use App\Http\Requests\UpdateFactoryCategoryRequest;
use App\Models\FactoryCategory;

class FactoryCategoryController extends Controller
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
     * @param  \App\Http\Requests\StoreFactoryCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFactoryCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FactoryCategory  $factoryCategory
     * @return \Illuminate\Http\Response
     */
    public function show(FactoryCategory $factoryCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FactoryCategory  $factoryCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(FactoryCategory $factoryCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFactoryCategoryRequest  $request
     * @param  \App\Models\FactoryCategory  $factoryCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFactoryCategoryRequest $request, FactoryCategory $factoryCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FactoryCategory  $factoryCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(FactoryCategory $factoryCategory)
    {
        //
    }
}
