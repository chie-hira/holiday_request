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
     * Get all of the approvals for the ApprovalCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function approvals()
    {
        return $this->hasMany(Approval::class, 'approval_id', 'id');
    }

}
