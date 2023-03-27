<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'approval_name',
    ];

    /**
     * Get all of the users for the ApprovalCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'approval_id', 'id');
    }
}
