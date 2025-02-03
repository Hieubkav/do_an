<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_item',
        'total_price',
        'customer_id',
    ];

    function cart_items(){
        return $this->hasMany(CartItem::class);
    }

    function customer(){
        return $this->belongsTo(Customer::class);
    }
}
