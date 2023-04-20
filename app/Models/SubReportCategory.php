<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubReportCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_report_name',
    ];

    /**
     * Get all of the reports for the SubReportCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports()
    {
        return $this->hasMany(Report::class, 'sub_report_id', 'id');
    }
}
