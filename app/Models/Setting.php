<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'banner_one_pic',        
        'banner_one_big_text',
        'banner_one_small_text',
        'banner_two_pic',        
        'banner_two_big_text',
        'banner_two_small_text',
        'address',
        'phone',
        'email',
        'shipping',
    ];
}
