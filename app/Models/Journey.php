<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journey extends Model
{
    protected $table = 'journeys';
    protected $fillable = [
        'year',
        'caption',
        'description',
        'image',
        'image_alt_text',
        'order',
        'status',
    ];
}
