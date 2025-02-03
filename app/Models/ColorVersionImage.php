<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorVersionImage extends Model
{
    use HasFactory;
    protected $fillable =[
        'color_id',
        'version_id',
        'image',
    ];

    function color(){
        return $this->belongsTo(Color::class);
    }
    function version(){
        return $this->belongsTo(Version::class);
    }
    function colorvertionsizes(){
        return $this->hasMany(ColorVersionSize::class);
    }
}
