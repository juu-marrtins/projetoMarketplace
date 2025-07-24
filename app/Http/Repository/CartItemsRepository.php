<?php 

namespace App\Http\Repository;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartItemsRepository
{
    public function allItems()
    {
        $cart = Auth::user()->cart()->with('cartItems')->first();

        if(!$cart){
            return 'no_cart';
        }

        $items = $cart->cartItems;

        return $items;
    }

    public function insert(array $dataValidated)
    {
        return CartItem::create($dataValidated);
    }

    public function findCartItemByProductId(string $productId)
    {
        $cartId = Auth::user()->cart->id;
        return CartItem::where('cartId', $cartId)
                        ->where('productId', $productId)
                        ->first();
    }

    public function incrementQuantity(string $productId, int $newQuantity)
    {
        $product = $this->findCartItemByProductId($productId);

        $product->quantity += $newQuantity;
        $product->save();

        return $product;
    }
}