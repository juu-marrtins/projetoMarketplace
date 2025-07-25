<?php

namespace App\Http\Services;

use App\Http\Repository\CartItemsRepository;
use App\Http\Services\Moderator\ProductService;
use Illuminate\Support\Facades\Auth;

class CartItemsService
{
    public function __construct(
        protected CartItemsRepository $cartItemsRepository,
        protected ProductService $productService)
    {}

    public function getItems()
    {
        
        $items = $this->cartItemsRepository->allItems();

        if ($items === 'no_cart') {
            return 'no_cart';
        }

        if (is_null($items) || $items->isEmpty()) {
            return null;
        }
        
        return $items;
    }

    public function insertItem(array $dataValidated)
    {
        $cart = Auth::user()->cart;
        
        if (!$cart) {
            return 'no_cart';
        }

        $dataValidated['cartId'] = $cart->id;
        $productId = $dataValidated['productId'];
        $product = $this->productService->findProductById($productId);

        $stock = $this->getStockItem($productId);
        if ($stock === null) {
            return 'no_stock';
        }

        $hasItem = $this->cartItemsRepository->findCartItemByProductId($productId);
        $newQty = $dataValidated['quantity'];
        $currentQty = $hasItem ? $hasItem->quantity : 0;

        if (($currentQty + $newQty) > $stock) {
            return 'no_stock';
        }

        if ($hasItem) {
            $this->incrementItem($dataValidated);
        } else {
            $this->cartItemsRepository->insert($dataValidated);
        }

        return true;
    }


    public function getStockItem(string $id)
    {
        $product = $this->productService->findProductById($id);
        if(!$product)
        {
            return null;
        }
        return $product->stock;
    }

    public function incrementItem(array $dataValidated)
    {
        return $this->cartItemsRepository->incrementQuantity(
            $dataValidated['productId'],
            $dataValidated['quantity']);
    }

    public function deleteItem(array $dataValidated)
    {
        $productId = $dataValidated['productId'];
        $item = $this->cartItemsRepository->findCartItemByProductId($productId);

        if(!$item)
        {
            return null;
        }

        return $item->delete();
    }
}