<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyCartItemRequest;
use App\Http\Requests\InsertCartItemsRequest;
use App\Http\Services\CartItemsService;

class CartItemsController extends Controller
{
    public function __construct(protected CartItemsService $cartItemsService)
    {}

    public function itemsCart()
    {
        $cartItems = $this->cartItemsService->getItems();

        if($cartItems === 'no_cart')
        {
            return response()->json([
                'success' => false,
                'message' => 'Carrinho nao encontrado.'
            ], 404);
        }
        if ($cartItems === null || $cartItems->isEmpty())
        {
            return response()->json([
                'success' => false,
                'message' => 'Carrinho vazio.',
                'data' => []
            ], 200);
        }

        return response()->json([
            'success' => true,
            'data' => $cartItems
        ], 200);
    }

    public function insert(InsertCartItemsRequest $request)
    {
        $this->cartItemsService->insertItem($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Produto inserido no carrinho com sucesso!'
        ], 200);
    }

    public function destroy(DestroyCartItemRequest $request)
    {
        $cartItem = $this->cartItemsService->deleteItem($request->validated());

        if(!$cartItem)
        {
            return response()->json([
                'success' => false,
                'message' => 'Produto nao encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => "Produto excluido do carrinho com sucesso!"
        ], 200);
    }
}
