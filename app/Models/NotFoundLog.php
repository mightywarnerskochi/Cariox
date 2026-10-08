<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotFoundLog extends Model
{
    protected $fillable = ['path', 'hits', 'referer', 'user_agent', 'last_seen_at'];

    protected $casts = [
        'last_seen_at' => 'datetime',
    ];
}
