<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApprovalCategoryRequest;
use App\Http\Requests\UpdateApprovalCategoryRequest;
use App\Models\ApprovalCategory;

class ApprovalCategoryController extends Controller
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
     * @param  \App\Http\Requests\StoreApprovalCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApprovalCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApprovalCategory  $approvalCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ApprovalCategory $approvalCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApprovalCategory  $approvalCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ApprovalCategory $approvalCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateApprovalCategoryRequest  $request
     * @param  \App\Models\ApprovalCategory  $approvalCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApprovalCategoryRequest $request, ApprovalCategory $approvalCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApprovalCategory  $approvalCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApprovalCategory $approvalCategory)
    {
        //
    }
}
