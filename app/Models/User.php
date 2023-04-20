<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'employee',
        'factory_id',
        'department_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all of the remainings for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function remainings()
    {
        return $this->hasMany(Remaining::class, 'user_id', 'id');
    }

    /**
     * Get all of the reports for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports()
    {
        return $this->hasMany(Report::class, 'user_id', 'id');
    }

    /**
     * Get all of the approvals for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function approvals()
    {
        return $this->hasMany(Approval::class, 'user_id', 'id');
    }

    /**
     * Get the factory that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function factory()
    {
        return $this->belongsTo(FactoryCategory::class, 'factory_id', 'id');
    }

    /**
     * Get the department that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(
            DepartmentCategory::class,
            'department_id',
            'id'
        );
    }

    // メソッド
    public function getApprovalName($approval_id)
    {
        // dd(1);
        $approval = ApprovalCategory::find($approval_id);
        // dd($approval->approval_name);
        return $approval->approval_name;
    }
    public function getApprovalDepartment($department_id)
    {
        $department = DepartmentCategory::find($department_id);
        return $department->department_name;
    }

    // アクセサ
    public function getSumGetDaysAttribute()
    {
        $sum_get_days = $this->reports
            ->where('approval1', '=', 1)
            ->where('approval2', '=', 1)
            ->where('approval3', '=', 1)
            ->groupBy('report_id')
            ->map(function ($report_id) {
                return $report_id->sum('get_days');
            });
        return $sum_get_days;
    }

    # 関数
    public function sumGetDaysOnly($key)
    {
        $sum_get_day = $this->sum_get_days[$key];
        $exp = explode('.', $sum_get_day);
        return $exp[0];
    }
    public function sumGetHours($key)
    {
        $sum_get_day = $this->sum_get_days[$key];
        $exp = explode('.', $sum_get_day);
        if (array_key_exists(1, $exp)) {
            # 小数点以下あり(1日未満)
            $decimal_p = '0.' . $exp[1];
            $exp_hour = explode('.', $decimal_p * 8); # 8時間で1日
            return $exp_hour[0];
        } else {
            return 0;
        }
    }
    public function sumGetMinutes($key)
    {
        $sum_get_day = $this->sum_get_days[$key];
        $exp = explode('.', $sum_get_day);
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
    public function remainingDaysOnly($key)
    {
        $remaining = $this->remainings[$key]->remaining;
        $exp = explode('.', $remaining);
        return $exp[0];
    }
    public function remainingHours($key)
    {
        $remaining = $this->remainings[$key]->remaining;
        $exp = explode('.', $remaining);
        if (array_key_exists(1, $exp)) {
            # 小数点以下あり(1日未満)
            $decimal_p = '0.' . $exp[1];
            $exp_hour = explode('.', $decimal_p * 8); # 8時間で1日
            return $exp_hour[0];
        } else {
            return 0;
        }
    }
    public function remainingMinutes($key)
    {
        $remaining = $this->remainings[$key]->remaining;
        $exp = explode('.', $remaining);
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
}
