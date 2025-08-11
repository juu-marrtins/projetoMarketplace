<?php 

namespace App\Http\Repository;

use App\Enums\CartItems\CartItemsCartStatus;
use App\Models\CartItem;
use App\Models\User;

class CartItemsRepository
{
    public function allItems(User $user) 
    {
        $cart = $user->cart()->with('cartItems')->first();

        if(!$cart){
            return CartItemsCartStatus::CART_NOT_FOUND;
        }

        $items = $cart->cartItems;

        return $items;
    }

    public function insert(array $dataValidated) 
    {
        return CartItem::create($dataValidated);
    }

    public function findCartItemByProductId(string $productId, string $cartId) 
    {
        return CartItem::where('cartId', $cartId)
                        ->where('productId', $productId)
                        ->first();
    }

    public function incrementQuantity(string $productId, int $newQuantity, string $cartId) 
    {
        $cartItem = $this->findCartItemByProductId($productId, $cartId);

        $cartItem->quantity += $newQuantity;
        $cartItem->save();

        return $cartItem;
    }
}