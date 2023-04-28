<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupCategoryRequest;
use App\Http\Requests\UpdateGroupCategoryRequest;
use App\Models\GroupCategory;

class GroupCategoryController extends Controller
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
     * @param  \App\Http\Requests\StoreGroupCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GroupCategory  $groupCategory
     * @return \Illuminate\Http\Response
     */
    public function show(GroupCategory $groupCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GroupCategory  $groupCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(GroupCategory $groupCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGroupCategoryRequest  $request
     * @param  \App\Models\GroupCategory  $groupCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroupCategoryRequest $request, GroupCategory $groupCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GroupCategory  $groupCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroupCategory $groupCategory)
    {
        //
    }
}
