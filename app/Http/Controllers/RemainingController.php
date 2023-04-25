<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRemainingRequest;
use App\Http\Requests\UpdateRemainingRequest;
use App\Models\Remaining;
use App\Models\ReportCategory;
use Illuminate\Support\Facades\Auth;

class RemainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $own_remainings= Remaining::all()->where('user_id', '=', Auth::id());

        if (empty($own_remainings->first())) {
            $report_ids = [1, 2, 3, 5, 6, 7, 8, 14];
            foreach ($report_ids as $report_id) {
                self::newRemaining($report_id);
            }
            $own_remainings = Remaining::all()->where('user_id', '==', Auth::id());
        }

        return view('remainings.index')->with(compact('own_remainings'));
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
     * @param  \App\Http\Requests\StoreRemainingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRemainingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Remaining  $remaining
     * @return \Illuminate\Http\Response
     */
    public function show(Remaining $remaining)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Remaining  $remaining
     * @return \Illuminate\Http\Response
     */
    public function edit(Remaining $remaining)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRemainingRequest  $request
     * @param  \App\Models\Limit  $limit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRemainingRequest $request, Remaining $remaining)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Remaining  $remaining
     * @return \Illuminate\Http\Response
     */
    public function destroy(Remaining $remaining)
    {
        //
    }
}
