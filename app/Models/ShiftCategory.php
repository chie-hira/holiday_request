<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_code',
        'start_time',
        'end_time',
        'rest1_start_time',
        'rest1_end_time',
        'rest2_start_time',
        'rest2_end_time',
        'rest3_start_time',
        'rest3_end_time',
        'lunch_start_time',
        'lunch_end_time',
    ];

    /**
     * Get all of the reports for the ShiftCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports()
    {
        return $this->hasMany(Report::class, 'shift_id', 'id');
    }

    // アクセサ
    public function getWorkTimeAttribute()
    {
        return $this->work_time1 + $this->work_time2;
    }

    public function getWorkHoursAttribute()
    {
        if (
            is_int($this->work_time) ||
            (is_float($this->work_time) &&
                $this->work_time == (int) $this->work_time)
        ) {
            return $this->work_time;
        } else {
            return intval($this->work_time);
        }
    }

    public function getWorkMinutesAttribute()
    {
        // dd($this->work_time);
        if (
            is_int($this->work_time) ||
            (is_float($this->work_time) &&
                $this->work_time == (int) $this->work_time)
        ) {
            return 0;
        } else {
            return 30;
        }
    }

    public function getStartTimeHmAttribute()
    {
        $start_time = $this->start_time;

        return substr($start_time, 0, 5);
    }
    public function getEndTimeHmAttribute()
    {
        $end_time = $this->end_time;

        return substr($end_time, 0, 5);
    }
}
