<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_code',
        'start_time',
        'end_time',
        'rest1_start_time',
        'rest1_end_time',
        'rest2_start_time',
        'rest2_end_time',
        'rest3_start_time',
        'rest3_end_time',
        'lunch_start_time',
        'lunch_end_time',
    ];

    /**
     * Get all of the reports for the ShiftCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports()
    {
        return $this->hasMany(Report::class, 'shift_id', 'id');
    }
}
