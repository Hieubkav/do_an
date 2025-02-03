<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract; // Import interface này
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customer extends Model implements AuthenticatableContract // Triển khai interface này
{
    use HasFactory, Notifiable, Authenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address'
    ];

    function cart(){
        return $this->hasOne(Cart::class);
    }

    function orders(){
        return $this->hasMany(Order::class);
    }

}
