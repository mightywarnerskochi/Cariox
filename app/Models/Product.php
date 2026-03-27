<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'subcategory_id', 'brand_id', 'product_title',
        'sub_title', 'slug', 'description', 'brochure',
        'status', 'position'
    ];

    public function scopePositioned($query)
    {
        return $query->orderByRaw('position IS NULL, position ASC');
    }

    public function meta()
    {
        return $this->morphOne(Meta::class , 'metable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function keyFeatures()
    {
        return $this->hasMany(ProductKeyFeature::class);
    }

    public function videos()
    {
        return $this->hasMany(ProductVideo::class);
    }
}
