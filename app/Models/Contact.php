<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'country', 'country_logo', 'logo_alt', 'address', 'map_link', 'icon', 'icon_alt', 'order', 'status'
    ];

    public function phones()
    {
        return $this->hasMany(ContactPhone::class , 'contact_id')->orderBy('order');
    }

    public function emails()
    {
        return $this->hasMany(ContactEmail::class , 'contact_id')->orderBy('order');
    }
}
