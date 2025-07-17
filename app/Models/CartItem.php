<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{

    protected $fillable = [
        'cartId',
        'productId',
        'quantity',
        'unitPrice'
    ];

    public function cart(){
        return $this->belongsTo(Cart::class, 'cartId');
    }

    public function products(){
        return $this->belongsTo(Product::class, 'productId');
    }
}
