<?php

namespace App\Http\Repository;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartRepository
{
    public function getCart()
    {
        return Auth::user()->cart;
    }

    public function create()
    {
        return Cart::create([
            'userId' => Auth::user()->id
        ]);
    }
}