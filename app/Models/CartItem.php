<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'quantity',
        'price',
        'color_version_size_id',
        'cart_id',
    ];

    function cart(){
        return $this->belongsTo(Cart::class);
    }

    function colorversionsize(){
        return $this->belongsTo(ColorVersionSize::class,'color_version_size_id');
    }
}
