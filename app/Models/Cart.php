<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function user(){
        return $this->belongsTo(User::class, 'userId');
    }

    public function cartItems(){
        return $this->hasMany(CartItem::class, 'cartId');
    }
}
