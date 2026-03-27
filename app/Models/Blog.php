<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'author', 'date', 'image', 'image_1', 'image_2', 'image_alt',
        'short_description', 'detailed_description', 'sub_description',
        'meta_title', 'meta_keyword', 'meta_description', 'other_meta_tags',
        'position', 'status'
    ];

    public function scopePositioned($query)
    {
        return $query->orderByRaw('status = 1 DESC, position ASC')->orderBy('updated_at', 'desc');
    }
}
