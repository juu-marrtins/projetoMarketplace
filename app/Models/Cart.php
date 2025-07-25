<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $fillable = [
        'userId'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'userId');
    }

    public function items(){
        return $this->hasMany(CartItem::class, 'cartId', 'id');
    }

    public function cartItems(){
        return $this->hasMany(CartItem::class, 'cartId', 'id');
    }
}
