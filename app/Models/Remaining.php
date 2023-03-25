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
        'remaining_days',
        'am_pm',
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

    # アクセサ
    public function getDaysAttribute()
    {
        $exp = explode('.', $this->remaining_days);
        return $exp[0];
        // return $remaining->remaining_days;
        // return floor($remaining->remaining_days);
    }
    public function getHoursAttribute()
    {
        $exp = explode('.', $this->remaining_days);
        $exp_key1 = array_key_exists(1, $exp);
        if ($exp_key1) {
            return $exp[1]*0.8;
        } else {
            return 0;
        }
        // return $remaining->remaining_days;
        // return floor($remaining->remaining_days);
    }
}
