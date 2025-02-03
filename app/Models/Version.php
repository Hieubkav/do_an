<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'quantity',
        'color_id',
        'product_id',
    ];

    function product(){
        return $this->belongsTo(Product::class);
    }
    function color() {
        return $this->belongsTo(Color::class);
    }
    function colorversionimages(){
        return $this->hasMany(ColorVersionImage::class);
    }
    
}
