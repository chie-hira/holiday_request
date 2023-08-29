<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAcquisitionFormRequest;
use App\Http\Requests\UpdateAcquisitionFormRequest;
use App\Models\AcquisitionForm;

class AcquisitionFormController extends Controller
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
     * @param  \App\Http\Requests\StoreAcquisitionFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAcquisitionFormRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AcquisitionForm  $acquisitionForm
     * @return \Illuminate\Http\Response
     */
    public function show(AcquisitionForm $acquisitionForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AcquisitionForm  $acquisitionForm
     * @return \Illuminate\Http\Response
     */
    public function edit(AcquisitionForm $acquisitionForm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAcquisitionFormRequest  $request
     * @param  \App\Models\AcquisitionForm  $acquisitionForm
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAcquisitionFormRequest $request, AcquisitionForm $acquisitionForm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AcquisitionForm  $acquisitionForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(AcquisitionForm $acquisitionForm)
    {
        //
    }
}
