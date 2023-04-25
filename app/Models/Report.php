<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use App\Models\Remaining;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_date',
        'user_id',
        'report_id',
        'sub_report_id',
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

    # アクセサ
    public function getGetDaysOnlyAttribute()
    {
        $exp = explode('.', $this->get_days);
        return $exp[0];
    }
    public function getGetHoursAttribute()
    {
        $exp = explode('.', $this->get_days);
        if (array_key_exists(1, $exp)) { # 小数点以下あり(1日未満)
            $decimal_p = '0.'. $exp[1];
            $exp_hour = explode('.', $decimal_p * 8); # 8時間で1日
            return $exp_hour[0];
        } else {
            return 0;
        }
    }
    public function getGetMinutesAttribute()
    {
        $exp = explode('.', $this->get_days);
        if (array_key_exists(1, $exp)) { # 小数点以下あり(1日未満)
            $decimal_p = '0.'. $exp[1];
            $exp_hour = explode('.', $decimal_p * 8);
            if (array_key_exists(1, $exp_hour)) { # 小数点以下あり(1時間未満)
                $decimal_p = '0.'. $exp_hour[1];
                return round($decimal_p * 60);
            }
        } else {
            return 0;
        }
    }
}
