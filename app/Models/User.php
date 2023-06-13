<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\Registered;
use App\Notifications\Approved;
use App\Notifications\StoreReport;
use App\Notifications\UpdateReport;
use Carbon\Carbon;

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
        'group_id',
        'adoption_date',
        'birthday',
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

    /**
     * Get the group that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(GroupCategory::class, 'group_id', 'id');
    }

    // アクセサ
    public function getTeamAllAttribute()
    {
        $team =
            $this->factory->factory_name .
            $this->department->department_name .
            $this->group->group_name;
        return $team;
    }

    public function getTeamAttribute()
    {
        if ($this->group->id != 1) {
            $team =
                $this->department->department_name .
                ' ' .
                $this->group->group_name;
        }
        if ($this->department->id != 1 && $this->group->id == 1) {
            $team = $this->department->department_name;
        }
        if ($this->department->id == 1) {
            $team = '工場長';
        }

        return $team;
    }

    public function getSumGetDaysAttribute()
    {
        # 取得日数集計
        $sum_get_days = $this->reports
            ->where('approved', 1)
            ->where('cancel', 0)
            ->groupBy('report_id')
            ->map(function ($report_id) {
                return $report_id->sum('get_days');
            });

        return $sum_get_days;
    }

    public function getSumGetPaidHolidaysAttribute()
    {
        # 取得日数集計
        $sum_get_days = $this->reports
            ->where('report_id', 1)
            ->where('sub_report_id', '!=', 4) # 時間休み以外をカウント
            ->where('approved', 1)
            ->where('cancel', 0)
            ->sum('get_days');

        return $sum_get_days;
    }

    public function getLostPaidHolidaysAttribute()
    {
        # 年度末を年明け前後で同じ日付になるように定義
        if (Carbon::now()->month >= 4) {
            $year_end = new Carbon(Carbon::now()->addYear()->year . '-03-31'); # 年度末日
        } else {
            $year_end = new Carbon(Carbon::now()->year . '-03-31'); # 年度末日
        }

        # 有休残日数
        $paid_holidays = $this->remainings->where('report_id', 1)->first();

        /** 有休失効日数 */
        $adoption_date_carbon = new Carbon($this->adoption_date); # 採用年月日
        $diff = $adoption_date_carbon->diff($year_end); # 年度末-採用年月日
        $length_of_service = floatval($diff->y . '.' . $diff->m); # 年度末の勤続年数
        $remaining_now = $paid_holidays->remaining;

        switch ($length_of_service) {
            case $length_of_service < 1.5:
                $lost_days = 0;
                break;

            case $length_of_service >= 1.5 && $length_of_service < 2.5:
                $remaining_add = $remaining_now + 11;
                if ($remaining_add > 21) {
                    $lost_days = $remaining_add - 21;
                } else {
                    $lost_days = 0;
                }
                break;

            case $length_of_service >= 2.5 && $length_of_service < 3.5:
                $remaining_add = $remaining_now + 12;
                if ($remaining_add > 23) {
                    $lost_days = $remaining_add - 23;
                } else {
                    $lost_days = 0;
                }
                break;

            case $length_of_service >= 3.5 && $length_of_service < 4.5:
                $remaining_add = $remaining_now + 14;
                if ($remaining_add > 26) {
                    $lost_days = $remaining_add - 26;
                } else {
                    $lost_days = 0;
                }
                break;

            case $length_of_service >= 4.5 && $length_of_service < 5.5:
                $remaining_add = $remaining_now + 16;
                if ($remaining_add > 30) {
                    $lost_days = $remaining_add - 30;
                } else {
                    $lost_days = 0;
                }
                break;

            case $length_of_service >= 5.5 && $length_of_service < 6.5:
                $remaining_add = $remaining_now + 18;
                if ($remaining_add > 32) {
                    $lost_days = $remaining_add - 32;
                } else {
                    $lost_days = 0;
                }
                break;

            case $length_of_service >= 6.5:
                $remaining_add = $remaining_now + 20;
                if ($remaining_add > 40) {
                    $lost_days = $remaining_add - 40;
                } else {
                    $lost_days = 0;
                }
                break;
        }
        return $lost_days;
    }

    // メソッド(関数)
    public function getApprovalName($approval_id)
    {
        $approval = ApprovalCategory::find($approval_id);
        return $approval->approval_name;
    }
    public function getApprovalFactory($factory_id)
    {
        $factory = FactoryCategory::find($factory_id);
        return $factory->factory_name;
    }
    public function getApprovalDepartment($department_id)
    {
        $department = DepartmentCategory::find($department_id);
        return $department->department_name;
    }
    public function getApprovalGroup($group_id)
    {
        $group = GroupCategory::find($group_id);
        return $group->group_name;
    }

    public function sumGetDaysOnly($key)
    {
        # 取得日数だけ
        $sum_get_days = $this->sum_get_days;
        if ($sum_get_days->has($key)) {
            # keyの存在確認
            $exp = explode('.', $sum_get_days[$key]);
            return $exp[0];
        } else {
            return 0;
        }
    }
    public function sumGetHours($key)
    {
        # 取得時間だけ
        $sum_get_days = $this->sum_get_days;
        if ($sum_get_days->has($key)) {
            # keyの存在確認
            $exp = explode('.', $sum_get_days[$key]);
        } else {
            return 0;
        }

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
        # 取得分だけ
        $sum_get_days = $this->sum_get_days;
        if ($sum_get_days->has($key)) {
            # keyの存在確認
            $exp = explode('.', $sum_get_days[$key]);
        } else {
            return 0;
        }

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
        # 残日数だけ
        $remaining = $this->remainings->where('report_id', $key)->first();
        if ($remaining) {
            $exp = explode('.', $remaining->remaining);
            return $exp[0];
        } else {
            return 0;
        }
    }

    public function remainingHours($key)
    {
        # 残時間だけ
        $remaining = $this->remainings->where('report_id', $key)->first();
        if ($remaining) {
            $exp = explode('.', $remaining->remaining);

            if (array_key_exists(1, $exp)) {
                # 小数点以下あり(1日未満)
                $decimal_p = '0.' . $exp[1];
                $exp_hour = explode('.', $decimal_p * 8); # 8時間で1日
                return $exp_hour[0];
            } else {
                return 0;
            }
        }
    }
    public function remainingMinutes($key)
    {
        # 残分だけ
        $remaining = $this->remainings->where('report_id', $key)->first();
        if ($remaining) {
            $exp = explode('.', $remaining->remaining);

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

    public function remaining($report_category_id)
    {
        $remainings = $this->remainings;
        return $remainings
            ->where('report_id', '=', $report_category_id)
            ->first();
    }

    // メール通知
    # 新規ユーザー登録
    public function registered($val)
    {
        $this->notify(new Registered($val));
    }

    # 承認
    public function approved($report)
    {
        $this->notify(new Approved($report));
    }

    # 届出提出
    public function storeReport($report)
    {
        $this->notify(new StoreReport($report));
    }

    # 届出更新
    public function updateReport($report)
    {
        $this->notify(new UpdateReport($report));
    }
}
