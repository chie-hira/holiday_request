<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLimitRequest;
use App\Http\Requests\UpdateLimitRequest;
use App\Models\Limit;
use App\Models\ReportCategory;
use Illuminate\Support\Facades\Auth;

class LimitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $own_limits = Limit::all()->where('user_id', '=', Auth::id());

        if (empty($own_limits->first())) {
            $report_ids = [1, 4, 5, 6, 7, 8, 9, 15];
            // $report_ids = [1, 4, 5, 6, 7, 8, 9, 10, 15, 17];
            foreach ($report_ids as $report_id) {
                self::newLimit($report_id);
            }
            $own_limits = Limit::all()->where('user_id', '==', Auth::id());
        }
        // dd($own_limits);

        return view('limits.index')->with(compact('own_limits'));
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
     * @param  \App\Http\Requests\StoreLimitRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLimitRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Limit  $limit
     * @return \Illuminate\Http\Response
     */
    public function show(Limit $limit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Limit  $limit
     * @return \Illuminate\Http\Response
     */
    public function edit(Limit $limit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLimitRequest  $request
     * @param  \App\Models\Limit  $limit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLimitRequest $request, Limit $limit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Limit  $limit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Limit $limit)
    {
        //
    }
}
