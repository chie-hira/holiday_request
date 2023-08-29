<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_name',
        'max_days',
        'max_times',
    ];

    /**
     * Get all of the acquisition days for the ReportCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function acquisition_days()
    {
        return $this->hasMany(AcquisitionDay::class, 'report_id', 'id');
    }

    /**
     * Get all of the reports for the ReportCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports()
    {
        return $this->hasMany(Report::class, 'report_id', 'id');
    }

    /**
     * Get the acquisition_form that owns the ReportCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function acquisition_form()
    {
        return $this->belongsTo(AcquisitionForm::class, 'acquisition_id', 'id');
    }
}
