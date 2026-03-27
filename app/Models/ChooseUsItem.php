<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChooseUsItem extends Model
{
    protected $table = 'choose_us_items';
    protected $fillable = [
        'choose_id',
        'icon',
        'image',
        'text',
        'order',
        'status',
    ];

    public function chooseUs()
    {
        return $this->belongsTo(ChooseUs::class , 'choose_id');
    }
}
