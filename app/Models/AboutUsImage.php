<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUsImage extends Model
{
    protected $table = 'about_us_images';
    protected $fillable = [
        'about_us_id',
        'image',
        'alt_text',
        'status',
        'order',
    ];

    public function aboutUs()
    {
        return $this->belongsTo(AboutUs::class , 'about_us_id');
    }
}
