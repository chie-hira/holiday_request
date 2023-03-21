<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_name',
    ];

    /**
     * Get all of the users for the DepartmentCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'department_id', 'id');
    }
}
