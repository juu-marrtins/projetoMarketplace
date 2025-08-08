<?php

namespace App\Http\Services;

use App\Enums\Cart\CartDeleteStatus;
use App\Http\Repository\CartRepository;
use App\Models\User;

class CartService
{
    public function __construct(protected CartRepository $cartRepository)
    {}

    public function getCartAuth(User $user)
    {
        $cart = $user->cart;

        return $cart;
    }

    public function createCart(User $user)
    {
        return $this->cartRepository->create($user);
    }

    public function deleteCart(User $user)
    {
        $cart = $user->cart;

        if(!$cart){
            return CartDeleteStatus::NOT_FOUND;
        }

        $cart->delete();

        return $cart;
    }
}