<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    use HasFactory;

    /**
     * Get the report_category that owns the Reason
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function report_category()
    {
        return $this->belongsTo(ReportCategory::class, 'report_id', 'id');
    }

    /**
     * Get the reason_category that owns the Reason
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reason_category()
    {
        return $this->belongsTo(ReasonCategory::class, 'reason_id', 'id');
    }
}
