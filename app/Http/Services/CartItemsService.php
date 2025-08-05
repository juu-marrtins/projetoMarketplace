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
        protected ProductService $productService)
    {}

    public function getItems(User $user)
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
            return CartItemsInsertStatus::CART_NOT_FOUND;
        }

        $dataValidated['cartId'] = $cart->id;
        $productId = $dataValidated['productId'];

        $product = $this->productService->findProductById($productId);

        if(!$product)
        {
            return CartItemsInsertStatus::PRODUCT_NOT_FOUND;
        }

        $stock = $product->stock;

        $hasItem = $this->cartItemsRepository->findCartItemByProductId($productId, $user);
        $newQty = $dataValidated['quantity'];
        $currentQty = $hasItem ? $hasItem->quantity : 0;

        if ($stock === null || ($currentQty + $newQty) > $stock) {
            return CartItemsInsertStatus::STOCK_NOT_ENOUGH;
        }

        if ($hasItem) {
            $this->incrementItem($dataValidated, $user);
        } else {
            $this->cartItemsRepository->insert($dataValidated);
        }
        return $cart;
    }


    public function incrementItem(array $dataValidated, User $user)
    {
        return $this->cartItemsRepository->incrementQuantity(
            $dataValidated['productId'],
            $dataValidated['quantity'],
            $user);
    }

    public function deleteItem(array $dataValidated, User $user)
    {
        $productId = $dataValidated['productId'];
        $item = $this->cartItemsRepository->findCartItemByProductId($productId, $user);

        if(!$item)
        {
            return null;
        }

        return $item->delete();
    }
}