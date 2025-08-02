<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'categoryId',
        'name',
        'stock',
        'price',
        'image'
    ];
    
    public function category(){
        return $this->belongsTo(Category::class, 'categoryId');
    }

    public function cartItems(){
        return $this->hasMany(CartItem::class, 'productId');
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class, 'productId');
    }

    public function discounts(){
        return $this->hasMany(Discount::class, 'productId'); 
    }
}
