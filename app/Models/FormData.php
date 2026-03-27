<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormData extends Model
{
    use SoftDeletes;

    protected $table = 'form_datas';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'product_name',
        'message',
        'page_source',
        'page_url',
    ];
}
