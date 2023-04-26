<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchiveRemaining extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'report_id',
        'remaining_days',
        'am_pm',
    ];
}
