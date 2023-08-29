<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcquisitionForm extends Model
{
    use HasFactory;

    /**
     * Get all of the report_categories for the AcquisitionForm
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function report_categories()
    {
        return $this->hasMany(ReportCategory::class, 'acquisition_id', 'id');
    }
}
