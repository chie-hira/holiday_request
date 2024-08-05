<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\Registered;
use App\Notifications\Approved;
use App\Notifications\CancelReport;
use App\Notifications\DestroyReport;
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
        'id',
        'name',
        'email',
        'password',
        'employee',
        'affiliation_id',
        'adoption_date',
        'birthday',
        'remarks',
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
     * Get all of the acquisition days for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function acquisition_days()
    {
        return $this->hasMany(AcquisitionDay::class, 'user_id', 'id');
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
     * Get the affiliation that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function affiliation()
    {
        return $this->belongsTo(Affiliation::class, 'affiliation_id', 'id');
    }

    // アクセサ
    public function getAffiliationNameAttribute()
    {
        if ($this->affiliation->department_id == 1) {
            $affiliation_name = $this->affiliation->factory->factory_name;
        } elseif (
            $this->affiliation->department_id != 1 &&
            $this->affiliation->group_id == 1
        ) {
            $affiliation_name =
                $this->affiliation->factory->factory_name .
                ' ' .
                $this->affiliation->department->department_name;
        } else {
            $affiliation_name =
                $this->affiliation->factory->factory_name .
                ' ' .
                $this->affiliation->department->department_name .
                ' ' .
                $this->affiliation->group->group_name;
        }

        return $affiliation_name;
    }

    public function getDepartmentGroupNameAttribute()
    {
        if ($this->affiliation->department_id == 1) {
            $affiliation_name = '部長';
        } elseif (
            $this->affiliation->department_id != 1 &&
            $this->affiliation->group_id == 1
        ) {
            $affiliation_name = $this->affiliation->department->department_name;
        } else {
            $affiliation_name =
                $this->affiliation->department->department_name .
                ' ' .
                $this->affiliation->group->group_name;
        }

        return $affiliation_name;
    }

    # 有給休暇の取得日数集計
    public function getAcquisitionPaidHolidaysAttribute()
    {
        $acquisition_paid_holidays = $this->acquisition_days
            ->where('report_id', 1)
            ->first();
        return $acquisition_paid_holidays->acquisition_days;
    }

    # 有給休暇の失効日数
    public function getLostPaidHolidaysAttribute()
    {
        # 年度末を年明け前後で同じ日付になるように定義
        if (Carbon::now()->month >= 4) {
            $year_end = new Carbon(Carbon::now()->addYear()->year . '-03-31'); # 年度末日
        } else {
            $year_end = new Carbon(Carbon::now()->year . '-03-31'); # 年度末日
        }

        # 有休残日数
        $paid_holidays = $this->acquisition_days()
            ->where('report_id', 1)
            ->first();

        /** 有休失効日数 */
        $adoption_date_carbon = new Carbon($this->adoption_date); # 採用年月日
        $diff = $adoption_date_carbon->diff($year_end); # 年度末-採用年月日
        $length_of_service = floatval($diff->y . '.' . $diff->m); # 年度末の勤続年数
        $remaining_now = $paid_holidays->remaining_days;

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
    public function acquisitionDays($key)
    {
        $acquisition_day = $this->acquisition_days
            ->where('report_id', $key)
            ->first();
        return $acquisition_day->acquisition_days;
    }
    public function acquisitionHours($key)
    {
        $acquisition_day = $this->acquisition_days
            ->where('report_id', $key)
            ->first();
        return $acquisition_day->acquisition_hours;
    }
    public function acquisitionMinutes($key)
    {
        $acquisition_day = $this->acquisition_days
            ->where('report_id', $key)
            ->first();
        return $acquisition_day->acquisition_minutes;
    }

    public function remainingDays($key)
    {
        $acquisition_day = $this->acquisition_days
            ->where('report_id', $key)
            ->first();
        return $acquisition_day->remaining_days;
    }
    public function remainingHours($key)
    {
        $acquisition_day = $this->acquisition_days
            ->where('report_id', $key)
            ->first();
        return $acquisition_day->remaining_hours;
    }
    public function remainingMinutes($key)
    {
        $acquisition_day = $this->acquisition_days
            ->where('report_id', $key)
            ->first();
        return $acquisition_day->remaining_minutes;
    }

    public function acquisition($report_category_id)
    {
        $acquisition_days = $this->acquisition_days
            ->where('report_id', $report_category_id)
            ->first();
        return $acquisition_days;
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

    /** 削除申請 */
    public function cancelReport($report)
    {
        $this->notify(new CancelReport($report));
    }

    /** 申請削除 */
    public function destroyReport($report)
    {
        $this->notify(new DestroyReport($report));
    }
}
