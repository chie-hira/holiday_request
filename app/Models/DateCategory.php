<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DateCategory extends Model
{
    use HasFactory;

    /**
     * Get all of the calenders for the DateCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calenders()
    {
        return $this->hasMany(Calender::class, 'date_id', 'id');
    }
}
