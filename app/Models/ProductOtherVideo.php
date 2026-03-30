<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOtherVideo extends Model
{
    use HasFactory;

    protected $table = 'product_othervideos';

    protected $fillable = ['product_id', 'video_url', 'video_file'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
