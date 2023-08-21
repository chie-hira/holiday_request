<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
    ];

    /**
     * Get all of the affiliations for the GroupCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function affiliations()
    {
        return $this->hasMany(Affiliation::class, 'group_id', 'id');
    }
}
