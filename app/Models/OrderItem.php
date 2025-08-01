<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

    protected $fillable = [
        'orderId',
        'productId',
        'quantity',
        'unitPrice'
    ];
    
    public function product(){
        return $this->belongsTo(Product::class, 'productId');
    }

    public function order(){
        return $this->belongsTo(Order::class, 'orderId');
    }
}
