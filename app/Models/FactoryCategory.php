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
     * Get all of the users for the CompanyCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'factory_id', 'id');
    }

    /**
     * Get all of the approvals for the FactoryCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function approvals()
    {
        return $this->hasMany(Approval::class, 'factory_id', 'id');
    }
}
