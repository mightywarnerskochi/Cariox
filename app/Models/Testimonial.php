<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'designation',
        'rating',
        'content',
        'image',
        'alt_text',
        'position',
        'status',
    ];
}
