<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'des',
        'sex',
        'nose_tick',
        'material_id',
        'shape_id',
        'design_id',
        'source_id',
        'brand_id',
        'quantity',
        'quantity_version',
    ];

    function versions(){
        return $this->hasMany(Version::class);
    }
    function categories(){
        return $this->belongsToMany(Category::class,'category_products');
    }
    function brand(){
        return $this->belongsTo(Brand::class);
    }
    function material(){
        return $this->belongsTo(Material::class);
    }
    function shape(){
        return $this->belongsTo(Shape::class);
    }
    function design(){
        return $this->belongsTo(Design::class);
    }
    function source(){
        return $this->belongsTo(Source::class);
    }
    function imageproducts(){
        return $this->belongsToMany(ImageProduct::class,'image_product_items');
    }
}
