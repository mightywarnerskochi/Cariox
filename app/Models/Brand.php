<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'image',
        'alt_text',
        'position',
        'status',
    ];

    public function scopePositioned($query)
    {
        return $query->orderByRaw('status = 1 DESC, position ASC')->orderBy('updated_at', 'desc');
    }
}
