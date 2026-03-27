<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description',
        'image', 'image_alt_text', 'status', 'position'
    ];

    public function meta()
    {
        return $this->morphOne(Meta::class , 'metable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopePositioned($query)
    {
        return $query->orderByRaw('status = 1 DESC, position ASC')->orderBy('updated_at', 'desc');
    }
}
