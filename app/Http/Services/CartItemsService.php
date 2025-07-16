<?php

namespace App\Http\Services;

use App\Http\Repository\CartItemsRepository;

class CartItemsService
{
    public function __construct(protected CartItemsRepository $cartItemsRepository)
    {}

    public function getItems()
    {
        if(!$this->cartItemsRepository->allItems())
        {
            return "O usuario nao possue um carrinho.";
        }

        return $this->cartItemsRepository->allItems();
    }

    
}