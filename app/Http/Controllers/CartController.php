<?php

namespace App\Http\Controllers;

use App\Http\Services\CartService;
class CartController extends Controller
{
    public function __construct(protected CartService $cartService)
    {}

    public function cartUser()
    {
        $cart = $this->cartService->getCartAuth();

        if(!$cart)
        {
            return response()->json([
                'success' => false,
                'message' => 'Carrinho nao encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $cart
        ], 200);
    }

    public function store()
    {
        return response()->json([
            'success' => true,
            'message' => 'Carrinho criado com sucesso!',
            'data' => $this->cartService->createCart()
        ], 201);
    }

    public function destroy()
    {
        $cart = $this->cartService->deleteCart();

        if(!$cart)
        {
            return response()->json([
                'success' => false,
                'message' => 'Carrinho nao encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Carrinho excluido com sucesso!'
        ], 200);
    }
}
