<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'addressId',
        'couponId',
    ];
    
    public function address(){
        return $this->belongsTo(Address::class, 'addressId');
    }

    public function user(){
        return $this->belongsTo(User::class, 'userId');
    }

    public function coupon(){
        return $this->belongsTo(Coupon::class, 'couponId');
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class, 'orderId');
    }
}
