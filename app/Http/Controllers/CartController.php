<?php

namespace App\Http\Controllers;

use App\Http\Services\CartService;
class CartController extends Controller
{
    public function __construct(protected CartService $cartService)
    {}

    public function cartUser()
    {
        return response()->json([
            'Cart' => $this->cartService->getCartAuth()
        ], 200);
    }

    public function store()
    {
        return response()->json([
            'message' => 'Carrinho criado com sucesso!',
            'Cart' => $this->cartService->createCart()
        ], 201);
    }

    public function destroy()
    {
        return response()->json([
            'message' => $this->cartService->deleteCart()
        ], 200);
    }
}
