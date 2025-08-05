<?php

namespace App\Http\Controllers;

use App\Enums\Cart\CartCreateStatus;
use App\Enums\Cart\CartDeleteStatus;
use App\Helpers\ApiResponse;
use App\Http\Resources\CartResource;
use App\Http\Services\CartService;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService)
    {}

    public function cartUser()
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

    public function store()
    {
        $cart = $this->cartService->createCart(Auth::user());

        if($cart === CartCreateStatus::ALREADY_HAS_CART)
        {
            return ApiResponse::fail(
                'O usuário já possui um carrinho.',
                409);
        }
        return ApiResponse::success(
            'Carrinho criado com sucesso.',
            new CartResource($cart),
            201);
    }

    public function destroy()
    {
        $cart = $this->cartService->deleteCart(Auth::user());

        if($cart === CartDeleteStatus::NOT_FOUND)
        {
            return ApiResponse::fail(
                'Carrinho não encontrado.',
                404);
        }

        return response()->noContent();
    }
}
