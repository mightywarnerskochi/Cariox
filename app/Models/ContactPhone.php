<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactPhone extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['contact_id', 'phone_number', 'is_whatsapp', 'order', 'status'];
}
