<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calender extends Model
{
    use HasFactory;

    /**
     * Get the calender_category that owns the Calender
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function calender_category()
    {
        return $this->belongsTo(CalenderCategory::class, 'calender_id', 'id');
    }

    /**
     * Get the date_category that owns the Calender
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function date_category()
    {
        return $this->belongsTo(DateCategory::class, 'date_id', 'id');
    }
}
