<?php

namespace App\Http\Services;

use App\Http\Repository\CartRepository;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function __construct(protected CartRepository $cartRepository)
    {}

    public function getCartAuth()
    {
        if($this->cartRepository->getCart())
        {
            return "Carrinho vazio.";
        }
        return $this->cartRepository->getCart();
    }

    public function createCart()
    {
        return $this->cartRepository->create();
    }

    public function deleteCart()
    {
        Auth::user()->cart()->delete();
        return 'Carrinho excluido com sucesso!';
    }
}