<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Limit;
use App\Models\ReportCategory;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function newLimit($report_id)
    {
        $limit = new Limit();
        $limit->user_id = Auth::id();
        $limit->report_id = $report_id;
        $report_category = ReportCategory::find($report_id);
        $limit->limit_days = $report_category->max_days;
        $limit->limit_times = $report_category->max_times;
        return $limit->save();
    }
}
