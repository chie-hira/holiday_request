<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactoryCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'factory_name',
    ];

    /**
     * Get all of the affiliations for the FactoryCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function affiliations()
    {
        return $this->hasMany(Affiliation::class, 'factory_id', 'id');
    }
}
