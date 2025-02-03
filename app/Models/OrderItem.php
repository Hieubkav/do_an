<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'quantity',
        'price',
        'order_id',
        'color_version_size_id',
    ];

    function order(){
        return $this->belongsTo(Order::class);
    }

    function color_version_size(){
        return $this->belongsTo(ColorVersionSize::class);
    }
}
