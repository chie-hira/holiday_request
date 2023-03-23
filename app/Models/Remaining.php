<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Remaining extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'report_id',
        'limit_days',
        'limit_times',
    ];

    /**
     * Get the user that owns the Remaining
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the report_category that owns the Limit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function report_category()
    {
        return $this->belongsTo(ReportCategory::class, 'report_id', 'id');
    }
}
