<?php

namespace App\Http\Services;

use App\Enums\CartItems\CartItemsCartStatus;
use App\Enums\CartItems\CartItemsInsertStatus;
use App\Http\Repository\CartItemsRepository;
use App\Http\Services\Moderator\ProductService;
use App\Models\User;


class CartItemsService
{
    public function __construct(
        protected CartItemsRepository $cartItemsRepository,
        protected ProductService $productService,
        protected CartService $cartService)
    {}

    public function getCartItemsUserAuth(User $user) 
    {
        
        $items = $this->cartItemsRepository->allItems($user);

        if ($items === CartItemsCartStatus::CART_NOT_FOUND) {
            return CartItemsCartStatus::CART_NOT_FOUND;
        }

        if ($items->isEmpty()) {
            return CartItemsCartStatus::NO_ITEMS;
        }
        
        return $items;
    }

    public function insertItem(array $dataValidated, User $user) 
    {
        $cart = $user->cart;
        
        if (!$cart) {
            $cart = $this->cartService->createCart($user);
        }

        $dataValidated['cartId'] = $cart->id;
        $productId = $dataValidated['productId'];

        $product = $this->productService->findProductById($productId);

        if(!$product)
        {
            return CartItemsInsertStatus::PRODUCT_NOT_FOUND;
        }

        $stock = $product->stock;

        $hasItem = $this->cartItemsRepository->findCartItemByProductId($productId, $cart->id);
        $newQty = $dataValidated['quantity'];
        $currentQty = $hasItem ? $hasItem->quantity : 0;

        if ($stock === null || ($currentQty + $newQty) > $stock) {
            return CartItemsInsertStatus::STOCK_NOT_ENOUGH;
        }

        if ($hasItem) {
            $this->incrementItem($dataValidated, $cart->id);
        } else {
            $this->cartItemsRepository->insert($dataValidated);
        }
        return $cart;
    }


    public function incrementItem(array $dataValidated, string $cartId) 
    {
        return $this->cartItemsRepository->incrementQuantity(
            $dataValidated['productId'],
            $dataValidated['quantity'],
            $cartId);
    }

    public function deleteItem(string $productId, string $cartId) 
    {
        $item = $this->cartItemsRepository->findCartItemByProductId($productId, $cartId);
        if(!$item)
        {
            return null;
        }

        $item->delete();

        return $item;
    }
}