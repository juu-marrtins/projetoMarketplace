<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public function user(){
        return $this->belongsTo(User::class, 'userId');
    }

    public function orders(){
        return $this->hasMany(Order::class, 'addressId');
    }
}
