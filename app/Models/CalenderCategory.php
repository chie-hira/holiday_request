<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalenderCategory extends Model
{
    use HasFactory;

    /**
     * Get all of the calensers for the CalenderCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calensers()
    {
        return $this->hasMany(Calender::class, 'calender_id', 'id');
    }

    /**
     * Get all of the affiliations for the CalenderCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function affiliations()
    {
        return $this->hasMany(Affiliation::class, 'calender_id', 'id');
    }
}
