<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'link',
    ];
    function products(){
        return $this->belongsToMany(Product::class,'image_product_items');
    }
}
