<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Remaining;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_date',
        'user_id',
        'report_id',
        'reason_id',
        'reason_detail',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'get_days',
        'am_pm',
        'approval1',
        'approval2',
        'approval3',
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
     * Get the reason that owns the Report
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reason()
    {
        return $this->belongsTo(ReasonCategory::class, 'reason_id', 'id');
    }

    # アクセサ
    public function getGetDaysOnlyAttribute()
    {
        $exp = explode('.', $this->get_days);
        return $exp[0];
        // return $remaining->remaining_days;
        // return floor($remaining->remaining_days);
    }
    public function getGetHoursAttribute()
    {
        $exp = explode('.', $this->get_days);
        $exp_key1 = array_key_exists(1, $exp);
        if ($exp_key1) {
            $decimal_p = '0.'. $exp[1];
            return $decimal_p * 8; # 8時間で1日
        } else {
            return 0;
        }
        // return $remaining->remaining_days;
        // return floor($remaining->remaining_days);
    }

    // // FIXME:休業日考慮
    // public function getGetDaysAttribute()
    // {
    //     $start_date = Carbon::create($this->start_date);
    //     $end_date = Carbon::create($this->end_date);
    //     // return $start_date->diffInDays($end_date);
    //     $diff_days = $start_date->diffInDays($end_date);

    //     $remainder_days = $diff_days % 7;
    //     $day_offs = ($diff_days - $remainder_days) / 7 * 2;
    //     $start_day = date('w', strtotime($start_date)); //0~6の曜日数値
    //     // dd($start_day);
    //     for ($i = 0; $i < $remainder_days; $i++) {
    //         if ($start_day + $i == 0 || $start_day + $i == 6) {
    //             //定休日の配列に含まれる場合、休日数に加算する
    //             $day_offs++;
    //         }
    //     }

    //     return $diff_days - $day_offs;
    // }
}
