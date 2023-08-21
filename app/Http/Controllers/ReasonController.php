<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReasonRequest;
use App\Http\Requests\UpdateReasonRequest;
use App\Models\Reason;

class ReasonController extends Controller
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
     * @param  \App\Http\Requests\StoreReasonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReasonRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reason  $reason
     * @return \Illuminate\Http\Response
     */
    public function show(Reason $reason)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reason  $reason
     * @return \Illuminate\Http\Response
     */
    public function edit(Reason $reason)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReasonRequest  $request
     * @param  \App\Models\Reason  $reason
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReasonRequest $request, Reason $reason)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reason  $reason
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reason $reason)
    {
        //
    }
}
