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
        $cart = $this->cartRepository->getCart();
        if(!$cart)
        {
            return "Carrinho vazio.";
        }
        return $cart;
    }

    public function createCart()
    {
        return $this->cartRepository->create();
    }

    public function deleteCart()
    {
        $cart = Auth::user()->cart;
        if(!$cart){
            return 'Nenhum carrinho apra excluir';
        }
        $cart->delete();
        return 'Carrinho excluido com sucesso!';
    }
}