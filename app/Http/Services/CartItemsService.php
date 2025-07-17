<?php

namespace App\Http\Services;

use App\Http\Repository\CartItemsRepository;
use Illuminate\Support\Facades\Auth;

class CartItemsService
{
    public function __construct(protected CartItemsRepository $cartItemsRepository)
    {}

    public function getItems()
    {
        $items = $this->cartItemsRepository->allItems();

        if(!$items)
        {
            return "Carrinho vazio.";
        }

        return $items;
    }

    public function insertItem(array $dataValidated)
    {
        $cart = Auth::user()->cart;
        if(!$cart)
        {
            return 'O usuario nao possue carrinho';
        }
        
        $dataValidated['cartId'] = $cart->id;
        $productId = $dataValidated['productId'];
        $hasItem = $this->cartItemsRepository->findItemById($productId);

        if($hasItem){
            return $this->incrementItem($dataValidated);
        } 

        return $this->cartItemsRepository->insert($dataValidated);
    }

    public function incrementItem(array $dataValidated)
    {
        return $this->cartItemsRepository->incrementQuantity(
            $dataValidated['productId'],
            $dataValidated['quantity']);
    }

    public function deleteItem(array $dataValidated)
    {
        $itemId = $dataValidated['productId'];
        $this->cartItemsRepository->delete($itemId);
        return "Item excluido com sucesso!";
    }
}