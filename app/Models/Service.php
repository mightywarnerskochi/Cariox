<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'home_description',
        'page_description',
        'main_description',
        'background_image',
        'background_image_alt_text',
        'main_image',
        'main_image_alt_text',
        'base_image1',
        'base_image1_alt_text',
        'base_image2',
        'base_image2_alt_text',
        'status',
        'position',
    ];

    public function meta()
    {
        return $this->morphOne(Meta::class, 'metable');
    }
}
