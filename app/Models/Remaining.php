<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Remaining extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'report_id', 'remaining_days', 'am_pm'];

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
    /** 残日数の時間だけ */
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
}
