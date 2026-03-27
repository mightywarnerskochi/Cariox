<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'alt_text',
        'image',
        'position',
        'status'
    ];

    public function scopePositioned($query)
    {
        return $query->orderByRaw('status = 1 DESC, position ASC')->orderBy('updated_at', 'desc');
    }
}
