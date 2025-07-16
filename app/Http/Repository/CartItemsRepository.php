<?php 

namespace App\Http\Repository;

use Illuminate\Support\Facades\Auth;

class CartItemsRepository
{
    public function allItems()
    {
        $cart = Auth::user()->cart;
        return $cart->items();
    }
}