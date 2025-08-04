<?php

namespace App\Http\Services;

use App\Enums\CartCreateStatus;
use App\Enums\CartDeleteStatus;
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
        if($user->cart)
        {
            return CartCreateStatus::ALREADY_HAS_CART;
        }

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