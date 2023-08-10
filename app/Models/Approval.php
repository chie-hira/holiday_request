<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'affiliation_id',
        'approval_id',
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
     * Get the affiliation that owns the Approval
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function affiliation()
    {
        return $this->belongsTo(Affiliation::class, 'affiliation_id', 'id');
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
