<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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

    protected static function booted()
    {
        // The website brand filter matches on slug, so every brand needs a unique one.
        static::saving(function (Brand $brand) {
            if (blank($brand->slug) || $brand->isDirty('name')) {
                $base = Str::slug($brand->name) ?: 'brand';
                $slug = $base;
                $i = 2;
                while (static::withTrashed()->where('slug', $slug)->whereKeyNot($brand->id)->exists()) {
                    $slug = $base . '-' . $i++;
                }
                $brand->slug = $slug;
            }
        });
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
