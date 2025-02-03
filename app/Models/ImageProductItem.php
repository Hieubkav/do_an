<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageProductItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'image_product_id',
        'product_id',
    ];
}
