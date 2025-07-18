<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'categoryId',
        'name',
        'stock',
        'price'
    ];
    
    public function category(){
        return $this->belongsTo(Category::class, 'categoryId');
    }

    public function cartItems(){
        return $this->hasMany(CartItem::class, 'productId');
    }

    public function ordemItems(){
        return $this->hasMany(OrderItem::class, 'productId');
    }

    public function discounts(){
        return $this->belongsTo(Discount::class, 'productId'); 
    }
}
