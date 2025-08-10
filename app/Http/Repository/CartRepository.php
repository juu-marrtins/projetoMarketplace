<?php

namespace App\Http\Repository;

use App\Models\Cart;
use App\Models\User;

class CartRepository
{
    public function create(User $user) : Cart
    {
        return Cart::create([
            'userId' => $user->id
        ]);
    }
}