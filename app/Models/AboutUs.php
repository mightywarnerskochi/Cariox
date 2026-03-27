<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $table = 'about_us';
    protected $fillable = [
        'detailed_description',
        'experience_caption',
        'years_of_experience',
        'vision',
        'mission',
        'status',
    ];

    public function images()
    {
        return $this->hasMany(AboutUsImage::class , 'about_us_id');
    }
}
