<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeBannerContent extends Model
{
    protected $fillable = [
        'small_title', 'main_title', 'description', 'button_text', 'button_link',
        'trusted_clients_count', 'trusted_clients_label', 'rating_label', 'google_rating',
        'review_label', 'position', 'status'
    ];

    public function media()
    {
        return $this->hasMany(HomeBannerMedia::class);
    }

    public function trustedClients()
    {
        return $this->hasMany(TrustedClient::class);
    }
}
