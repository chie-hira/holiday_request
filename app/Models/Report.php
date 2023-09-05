<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'report_date',
        'user_id',
        'report_id',
        'sub_report_id',
        'reason_id',
        'reason_detail',
        'shift_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'acquisition_days',
        'acquisition_hours',
        'acquisition_minutes',
        'am_pm',
        'approval1',
        'approval2',
        'approved',
        'cancel',
    ];

    /**
     * Get the user that owns the Report
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the report_category that owns the Report
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function report_category()
    {
        return $this->belongsTo(ReportCategory::class, 'report_id', 'id');
    }

    /**
     * Get the sub_report_category that owns the Report
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sub_report_category()
    {
        return $this->belongsTo(SubReportCategory::class, 'sub_report_id', 'id');
    }

    /**
     * Get the reason that owns the Report
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reason_category()
    {
        return $this->belongsTo(ReasonCategory::class, 'reason_id', 'id');
    }

    /**
     * Get the shift_category that owns the Report
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shift_category()
    {
        return $this->belongsTo(ShiftCategory::class, 'shift_id', 'id');
    }
}
