<?php

namespace App\Http\Controllers;

use App\Enums\CartItems\CartItemsCartStatus;
use App\Enums\CartItems\CartItemsInsertStatus;
use App\Helpers\ApiResponse;
use App\Http\Requests\DestroyCartItemRequest;
use App\Http\Requests\InsertCartItemsRequest;
use App\Http\Resources\CartItemsResource;
use App\Http\Services\CartItemsService;
use Illuminate\Support\Facades\Auth;

class CartItemsController extends Controller
{
    public function __construct(protected CartItemsService $cartItemsService)
    {}

    public function itemsCart()
    {
        $cartItems = $this->cartItemsService->getItems(Auth::user());

        if($cartItems === CartItemsCartStatus::CART_NOT_FOUND)
        {
            return ApiResponse::fail(
                'Carrinho não encontrado',
                404
            );
        }
        
        if ($cartItems === CartItemsCartStatus::NO_ITEMS)
        {
            return ApiResponse::success(
                'Carrinho vazio.',
                [],
                200
            );
        }

        return ApiResponse::success(
            'Listagem de items',
            CartItemsResource::collection($cartItems),
            200
        );
    }

    public function insert(InsertCartItemsRequest $request)
    {
        $cartItem = $this->cartItemsService->insertItem($request->validated(), Auth::user());

        if ($cartItem === CartItemsInsertStatus::CART_NOT_FOUND)
        {
            return ApiResponse::fail(
                'Carrinho não encontrado',
                404
            );
        }

        if ($cartItem === CartItemsInsertStatus::STOCK_NOT_ENOUGH)
        {
            return ApiResponse::fail(
                'Estoque insuficiente.',
                409
            );
        }
        
        return response()->noContent();
    }

    public function destroy(string $cartItemId)
    {
        $cart = Auth::user()->cart;
        $cartItem = $this->cartItemsService->deleteItem($cartItemId, $cart->id);

        if(!$cartItem)
        {
            return ApiResponse::fail(
                'Produto não encontrado no carrinho.',
                404
            );
        }

        return response()->noContent();
    }
}
