<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'company_name',
        'official_email',
        'official_phone',
        'official_whatsapp',
        'logo',
        'logo_alt_text',
        'footer_logo',
        'footer_logo_alt_text',
        'footer_logo_description',
        'copyright',
        'favicon',
        'terms_conditions',
        'privacy_policy',
        'facebook_link',
        'instagram_link',
        'linkedin_link',
        'twitter_link',
        'pinterest_link',
        'youtube_link',
        'gtm_ids',
        'custom_head_scripts',
        'custom_body_scripts'
    ];

    protected $appends = ['logo_url', 'favicon_url'];

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    public function getFaviconUrlAttribute(): ?string
    {
        return $this->favicon ? asset('storage/' . $this->favicon) : null;
    }
}
