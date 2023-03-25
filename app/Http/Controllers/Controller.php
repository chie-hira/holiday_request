<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Remaining;
use App\Models\ReportCategory;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function newRemaining($report_id)
    {
        $remaining = new Remaining();
        $remaining->user_id = Auth::id();
        $remaining->report_id = $report_id;
        $report_category = ReportCategory::find($report_id);
        $remaining->remaining = $report_category->max_days;
        return $remaining->save();
    }
}
