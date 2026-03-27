<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrustedClient extends Model
{
    protected $fillable = [
        'home_banner_content_id', 'client_image', 'alt_text', 'client_name', 'position', 'status'
    ];

    public function homeBannerContent()
    {
        return $this->belongsTo(HomeBannerContent::class);
    }
}
