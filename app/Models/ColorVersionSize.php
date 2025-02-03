<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorVersionSize extends Model
{
    use HasFactory;
    protected $fillable = [
        'color_version_image_id',
        'size_id',
        'quantity',
    ];

    function color_version_image(){
        return $this->belongsTo(ColorVersionImage::class);
    }
    function size(){
        return $this->belongsTo(Size::class);
    }

}
