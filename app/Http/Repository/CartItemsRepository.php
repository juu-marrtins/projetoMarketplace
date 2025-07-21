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
            return 'Usuário não possui carrinho';
        }

        $items = $cart->cartItems;

        if($items->isEmpty()){
            return 'Carrinho vazio';
        }

        return $items;
    }

    public function insert(array $dataValidated)
    {
        return CartItem::create($dataValidated);
    }

    public function findItemById(string $productId)
    {
        $cartId = Auth::user()->cart->id;
        return CartItem::where('cartId', $cartId)
                        ->where('productId', $productId)
                        ->first();
    }

    public function incrementQuantity(string $productId, int $newQuantity)
    {
        $product = $this->findItemById($productId);

        $product->quantity +=  $newQuantity;
        $product->save();

        return $product;
    }

    public function delete(string $itemId)
    {
        $item = $this->findItemById($itemId);
        return $item->delete();
    }
}