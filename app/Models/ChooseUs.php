<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChooseUs extends Model
{
    protected $table = 'choose_us';
    protected $fillable = [
        'title',
        'description',
        'image',
        'image_alt_text',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(ChooseUsItem::class , 'choose_id');
    }
}
