<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Remaining extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'report_id', 'remaining_days', 'am_pm'];

    public $appends = ['pending_get_days'];

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
    /** 残日数の日数だけ */
    public function getRemainingDaysAttribute()
    {
        $exp = explode('.', $this->remaining);
        return $exp[0];
    }
    /** 残日数の時間だけ */
    public function getRemainingHoursAttribute()
    {
        $exp = explode('.', $this->remaining);
        $exp_key1 = array_key_exists(1, $exp);
        if ($exp_key1) {
            $decimal_p = '0.' . $exp[1];
            return $decimal_p * 8; # 8時間で1日
        } else {
            return 0;
        }
    }

    /** 承認待ちの取得日数 */
    public function getGetDaysAttribute()
    {
        $reports = Auth::user()
            ->reports->where('report_id', $this->report_id)
            ->where('approved', 0)
            ->where('cancel', 0);
        return $reports->sum('get_days');
    }

    /** 残日数の日数だけ */
    public function getExpectationDaysAttribute()
    {
        $exp = explode('.', $this->remaining - $this->get_days);
        return $exp[0];
    }
    /** 取得日数の時間だけ */
    public function getExpectationHoursAttribute()
    {
        $exp = explode('.', $this->remaining - $this->get_days);
        if (array_key_exists(1, $exp)) {
            # 小数点以下あり(1日未満)
            $decimal_p = '0.' . $exp[1];
            $exp_hour = explode('.', $decimal_p * 8); # 8時間で1日
            return $exp_hour[0];
        } else {
            return 0;
        }
    }
    /** 取得日数の分だけ */
    public function getExpectationMinutesAttribute()
    {
        $exp = explode('.', $this->remaining - $this->get_days);
        if (array_key_exists(1, $exp)) {
            # 小数点以下あり(1日未満)
            $decimal_p = '0.' . $exp[1];
            $exp_hour = explode('.', $decimal_p * 8);
            if (array_key_exists(1, $exp_hour)) {
                # 小数点以下あり(1時間未満)
                $decimal_p = '0.' . $exp_hour[1];
                return round($decimal_p * 60);
            }
        } else {
            return 0;
        }
    }

    /** 承認待ちの取得日数 */
    public function getPendingGetDaysAttribute()
    {
        $reports = Auth::user()
            ->reports->where('report_id', $this->report_id)
            ->where('approved', 0)
            ->where('cancel', 0);
        return $reports->sum('get_days');
    }
}
