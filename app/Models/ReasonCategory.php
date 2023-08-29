<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReasonCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'reason',
    ];

    /**
     * Get all of the reports for the ReasonCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports()
    {
        return $this->hasMany(Report::class, 'reason_id', 'id');
    }

    /**
     * Get all of the reasons for the ReasonCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reasons()
    {
        return $this->hasMany(Reason::class, 'reason_id', 'id');
    }
}
