<?php

namespace App\Http\Controllers;

use App\Http\Services\CartService;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        return response()->json([
            'message' => 'Carrinho criado com sucesso!',
            'Cart' => $this->cartService->createCart()
        ], 201);
    }

    public function destroy(string $id)
    {
        return response()->json([
            'message' => $this->cartService->deleteCart()
        ], 200);
    }
}
