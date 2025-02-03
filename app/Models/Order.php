<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
        'total_item',
        'total_price',
        'customer_id',
    ];

    function order_items(){
        return $this->hasMany(OrderItem::class);
    }

    function customer(){
        return $this->belongsTo(Customer::class);
    }
}
