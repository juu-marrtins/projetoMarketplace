<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    public function cart(){
        return $this->belongsTo(Cart::class, 'cartId');
    }

    public function products(){
        return $this->belongsTo(Product::class, 'productId');
    }
}
