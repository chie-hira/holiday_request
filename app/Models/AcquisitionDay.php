<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AcquisitionDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'report_id',
        'remaining_days',
        'remaining_hours',
        'remaining_minutes',
        'acquisition_days',
        'acquisition_hours',
        'acquisition_minutes',
    ];

    public $appends = [
        'pending_acquisition_days',
        'pending_acquisition_hours',
        'pending_acquisition_minutes',
        'expectation_remaining_days',
        'expectation_remaining_hours',
        'expectation_remaining_minutes',
    ];

    /**
     * Get the user that owns the Acquisition days
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
    // /** 承認済みの取得日数集計 */
    // public function getSumGetDaysAttribute()
    // {
    //     $sum_report = Report::where('user_id',$this->user_id)
    //             ->where('report_id',$this->report_id)
    //             ->where('approved',1)
    //             ->get();
    //     return $sum_report->sum('get_days');
    // }
    /** 承認済みの取得日数集計の日数だけ */
    // public function getSumGetDaysOnlyAttribute()
    public function getAcquisitionDaysOnlyAttribute()
    {
        // $exp = explode('.', $this->sum_get_days);
        $exp = explode('.', $this->acquisition_days);
        return $exp[0];
    }
    /** 承認済みの取得日数集計の時間だけ */
    // public function getAcquisitionHoursAttribute()
    // {
    //     $exp = explode('.', $this->acquisition_days);
    //     if (array_key_exists(1, $exp)) {
    //         # 小数点以下あり(1日未満)
    //         $decimal_p = '0.' . $exp[1];
    //         $exp_hour = explode('.', $decimal_p * 8); # 8時間で1日
    //         return $exp_hour[0];
    //     } else {
    //         return 0;
    //     }
    // }

    /** 承認待ちの取得日数 */
    public function getPendingGetDaysAttribute()
    {
        $reports = Auth::user()
            ->reports->where('report_id', $this->report_id)
            ->where('approved', 0)
            ->where('cancel', 0);
        return $reports->sum('get_days');
    }

    public function getPendingAcquisitionDaysAttribute()
    {
        $reports = Auth::user()
            ->reports->where('report_id', $this->report_id)
            ->where('approved', 0)
            ->where('cancel', 0);

        // もし$reportsが空の場合、0を返す
        if ($reports->isEmpty()) {
            return 0;
        }

        $acquisition_days = $reports->sum('acquisition_days');

        // 半日休は0.5日で加算
        $reports = $reports->filter(function ($item) {
            return $item->sub_report_id == 3;
        });
        $acquisition_days += count($reports)*0.5;

        // // 勤務時間の基準は最新の届出
        // $shift_id = $reports->last()->shift_id;
        // $working_time = ShiftCategory::find($shift_id)->work_time;
        // $sum_acquisition_hours = $reports->sum('acquisition_hours');

        // // sum_acquisition_minutesが60分以上のとき加算
        // $sum_acquisition_minutes = $reports->sum('acquisition_minutes');
        // if ($sum_acquisition_minutes > 60) {
        //     $acquisition_minutes = $sum_acquisition_minutes % 60;
        //     $sum_acquisition_hours +=
        //         ($sum_acquisition_minutes - $acquisition_minutes) / 60;
        // }

        // if ($sum_acquisition_hours > $working_time) {
        //     $acquisition_hours = $sum_acquisition_hours % $working_time;
        //     $acquisition_days +=
        //         ($sum_acquisition_hours - $acquisition_hours) / $working_time;
        // }

        return $acquisition_days;
    }

    public function getPendingAcquisitionHoursAttribute()
    {
        $reports = Auth::user()
            ->reports
            ->where('report_id', $this->report_id)
            ->where('approved', 0)
            ->where('cancel', 0);

        // もし$reportsが空の場合、0を返す
        if ($reports->isEmpty()) {
            return 0;
        }

        // 勤務時間の基準は最新の届出
        // $shift_id = $reports->last()->shift_id;
        // $working_time = ShiftCategory::find($shift_id)->work_time;
        $acquisition_hours = $reports->sum('acquisition_hours');

        // 半日休は0.5日で加算
        $reports = $reports->filter(function ($item) {
            return $item->sub_report_id == 3;
        });
        $acquisition_hours -= $reports->sum('acquisition_hours');

        // sum_acquisition_minutesが60分以上のとき加算
        $sum_acquisition_minutes = $reports->sum('acquisition_minutes');
        if ($sum_acquisition_minutes > 60) {
            $acquisition_minutes = $sum_acquisition_minutes % 60;
            $acquisition_hours +=
                ($sum_acquisition_minutes - $acquisition_minutes) / 60;
        }

        // if ($sum_acquisition_hours < $working_time) {
        //     $acquisition_hours = $sum_acquisition_hours;
        // } else {
        //     $acquisition_hours = $sum_acquisition_hours % $working_time;
        // }

        return $acquisition_hours;
    }

    public function getPendingAcquisitionMinutesAttribute()
    {
        $reports = Auth::user()
            ->reports->where('report_id', $this->report_id)
            ->where('approved', 0)
            ->where('cancel', 0);

        // もし$reportsが空の場合、0を返す
        if ($reports->isEmpty()) {
            return 0;
        }

        $sum_acquisition_minutes = $reports->sum('acquisition_minutes');
        if ($sum_acquisition_minutes < 60) {
            $acquisition_minutes = $sum_acquisition_minutes;
        } else {
            $acquisition_minutes = $sum_acquisition_minutes % 60;
        }

        return $acquisition_minutes;
    }

    /** 承認待ちの取得日数集計の日数だけ */
    public function getPendingAcquisitionDaysOnlyAttribute()
    {
        $exp = explode('.', $this->pending_acquisition_days);
        return $exp[0];
    }
    /** 承認待ちの取得日数集計の時間だけ */
    public function getPendingGetHoursAttribute()
    {
        $exp = explode('.', $this->pending_acquisition_days);
        if (array_key_exists(1, $exp)) {
            # 小数点以下あり(1日未満)
            $decimal_p = '0.' . $exp[1];
            $exp_hour = explode('.', $decimal_p * 8); # 8時間で1日
            return $exp_hour[0];
        } else {
            return 0;
        }
    }
    /** 承認待ちの取得日数集計の分だけ */
    public function getPendingGetMinutesAttribute()
    {
        $exp = explode('.', $this->pending_acquisition_days);
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

    // /** 残日数の日数だけ */
    public function getRemainingDaysOnlyAttribute()
    {
        $exp = explode('.', $this->remaining_days);
        return $exp[0];
    }
    /** 残日数の時間だけ */
    // public function getRemainingHoursAttribute()
    // {
    //     $exp = explode('.', $this->remaining_days);
    //     $exp_key1 = array_key_exists(1, $exp);
    //     if ($exp_key1) {
    //         $decimal_p = '0.' . $exp[1];
    //         return $decimal_p * 8; # 8時間で1日
    //     } else {
    //         return 0;
    //     }
    // }

    /** 承認待ちの取得日数 */
    // public function getGetDaysAttribute()
    // {
    //     $reports = Auth::user()
    //         ->reports->where('report_id', $this->report_id)
    //         ->where('approved', 0)
    //         ->where('cancel', 0);
    //     return $reports->sum('get_days');
    // }

    /** 残日数の日数だけ */
    public function getExpectationDaysAttribute()
    {
        $exp = explode(
            '.',
            $this->remaining_days - $this->pending_acquisition_days
        );
        return $exp[0];
    }
    public function getExpectationRemainingDaysAttribute()
    {
        $expectation_days =
            $this->remaining_days - $this->pending_acquisition_days;
        if ($this->remaining_hours < $this->pending_acquisition_hours) {
            $expectation_days -= 1;
        }

        if ($this->remaining_minutes < $this->pending_acquisition_minutes) {
            $expectation_hours =
                $this->remaining_hours - $this->pending_acquisition_hours - 1;
            if ($expectation_hours < 0) {
                $expectation_days -= 1;
            }
        }

        return $expectation_days;
    }
    /** 取得日数の時間だけ */
    public function getExpectationHoursAttribute()
    {
        $exp = explode(
            '.',
            $this->remaining_days - $this->pending_acquisition_days
        );
        if (array_key_exists(1, $exp)) {
            # 小数点以下あり(1日未満)
            $decimal_p = '0.' . $exp[1];
            $exp_hour = explode('.', $decimal_p * 8); # 8時間で1日
            return $exp_hour[0];
        } else {
            return 0;
        }
    }
    public function getExpectationRemainingHoursAttribute()
    {
        $reports = Auth::user()
            ->reports->where('report_id', $this->report_id)
            ->where('approved', 0)
            ->where('cancel', 0);

        // もし$reportsが空の場合、0を返す
        if ($reports->isEmpty()) {
            return $this->remaining_hours;
        }

        // 勤務時間の基準は最新の届出
        $shift_id = $reports->last()->shift_id;
        $working_time = ShiftCategory::find($shift_id)->work_time;
        // $working_time = $reports->last()->shift_category->work_time;

        if ($this->remaining_hours >= $this->pending_acquisition_hours) {
            $expectation_hours =
                $this->remaining_hours - $this->pending_acquisition_hours;
        } else {
            $expectation_hours =
                $working_time +
                $this->remaining_hours -
                $this->pending_acquisition_hours;
        }

        return $expectation_hours;
    }
    /** 取得日数の分だけ */
    public function getExpectationMinutesAttribute()
    {
        if (!empty($this->remaining_days)) {
            $exp = explode(
                '.',
                $this->remaining_days - $this->pending_acquisition_days
            );
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
        } else {
            return 0;
        }
    }
    public function getExpectationRemainingMinutesAttribute()
    {
        if ($this->remaining_minutes >= $this->pending_acquisition_minutes) {
            $expectation_minutes =
                $this->remaining_minutes - $this->pending_acquisition_minutes;
        } else {
            $expectation_minutes =
                60 +
                $this->remaining_minutes -
                $this->pending_acquisition_minutes;
        }

        return $expectation_minutes;
    }
}
