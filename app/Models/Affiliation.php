<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliation extends Model
{
    use HasFactory;

    protected $fillable = [
        'factory_id',
        'department_id',
        'group_id',
    ];

    /**
     * Get all of the users for the Affiliation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'affiliation_id', 'id');
    }

    /**
     * Get all of the approvals for the Affiliation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function approvals()
    {
        return $this->hasMany(Approval::class, 'affiliation_id', 'id');
    }
    
    /**
     * Get the factory that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function factory()
    {
        return $this->belongsTo(FactoryCategory::class, 'factory_id', 'id');
    }

    /**
     * Get the department that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(
            DepartmentCategory::class,
            'department_id',
            'id'
        );
    }

    /**
     * Get the group that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(GroupCategory::class, 'group_id', 'id');
    }
}
