<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'factory_id',
        'department_id',
        'approval_id',
        'group_id',
    ];

    /**
     * Get the user that owns the Approval
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the factory that owns the Approval
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function factory()
    {
        return $this->belongsTo(FactoryCategory::class, 'factory_id', 'id');
    }

    /**
     * Get the department that owns the Approval
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(DepartmentCategory::class, 'department_id', 'id');
    }

    /**
     * Get the group that owns the Approval
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(GroupCategory::class, 'group_id', 'id');
    }

    /**
     * Get the approval_category that owns the Approval
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function approval_category()
    {
        return $this->belongsTo(ApprovalCategory::class, 'approval_id', 'id');
    }
}
