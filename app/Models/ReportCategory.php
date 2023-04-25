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
     * Get all of the remainings for the ReportCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function remainings()
    {
        return $this->hasMany(Remaining::class, 'report_id', 'id');
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
}
