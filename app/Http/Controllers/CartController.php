<?php

namespace App\Http\Controllers;

use App\Enums\Cart\CartDeleteStatus;
use App\Helpers\ApiResponse;
use App\Http\Resources\CartResource;
use App\Http\Services\CartService;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService)
    {}

    public function cartUser() // ok 2.0
    {
        $cart = $this->cartService->getCartAuth(Auth::user());

        if(!$cart)
        {
            return ApiResponse::fail(
                'Carrinho não encontrado.',
                404);
        }

        return ApiResponse::success(
            'Carrinho do usuário: ' . Auth::user()->name,
            new CartResource($cart),
            200);
    }

    public function destroy() // ok 2.0
    {
        $status = $this->cartService->deleteCart(Auth::user());
        
        match($status)
        {
            CartDeleteStatus::NOT_FOUND => ApiResponse::fail('Carrinho não encontrado.', 404),
            CartDeleteStatus::DELETED   => response()->noContent(),
            default                     => ApiResponse::fail('Erro ao excluir o carrinho.', 500)
        };
    }
}
