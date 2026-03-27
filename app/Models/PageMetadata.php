<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageMetadata extends Model
{
    protected $fillable = [
        'page_name',
        'canonical_url',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'other_meta',
    ];

    protected $appends = ['og_image_url'];

    /**
     * Full URL for the OG image (handles both Storage and legacy public paths).
     */
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
}
