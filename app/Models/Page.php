<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'pic',
        'content',
        'user_id',
        'image_id',
    ];
    
    function user(){
        return $this->belongsTo(User::class);
    }
    function image(){
        return $this->belongsTo(Image::class);
    }
}
