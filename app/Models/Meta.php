<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meta extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'metable_id', 'metable_type', 'meta_title', 'meta_keyword', 'meta_description',
        'other_meta_tags', 'og_title', 'og_description', 'og_image', 'canonical_url'
    ];

    protected $appends = ['og_image_url'];

    public function getOgImageUrlAttribute(): ?string
    {
        if (!$this->og_image) {
            return null;
        }
        if (str_starts_with($this->og_image, 'uploads/')) {
            return asset($this->og_image);
        }
        return asset('storage/' . $this->og_image);
    }

    public function metable()
    {
        return $this->morphTo();
    }
}
