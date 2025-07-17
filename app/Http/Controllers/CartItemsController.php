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
        return response()->json([
            'Cart Items' => $this->cartItemsService->getItems()
        ], 200);
    }

    public function insert(InsertCartItemsRequest $request)
    {
        $this->cartItemsService->insertItem($request->validated());
        return response()->json([
            'message' => 'Produto inserido no carrinho com sucesso!' // PERGUNTAR PRO MOACIR SE DA PRA FAZER ASSIM
        ], 200);
    }

    public function destroy(DestroyCartItemRequest $request)
    {
        return response()->json([
            'message' => $this->cartItemsService->deleteItem($request->validated())
        ], 200);
    }
}
