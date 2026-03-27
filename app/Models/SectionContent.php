<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class SectionContent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'section',
        'small_title',
        'main_title',
        'description',
        'button_label',
        'link',
    ];
}
