<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'startDate',
        'endDate',
        'discountPercentage'
    ];

    public function orders(){
        return $this->hasMany(Order::class, 'couponId');
    }
}
