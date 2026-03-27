<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeBannerMedia extends Model
{
    protected $fillable = [
        'home_banner_content_id', 'type', 'file_path', 'thumbnail_path', 'alt_text', 'position', 'status'
    ];

    public function homeBannerContent()
    {
        return $this->belongsTo(HomeBannerContent::class);
    }
}
