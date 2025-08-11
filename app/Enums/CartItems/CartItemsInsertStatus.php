<?php

namespace App\Enums\CartItems;

enum CartItemsInsertStatus : string
{
    case CART_NOT_FOUND = 'cart_not_found';
    case STOCK_NOT_ENOUGH = 'stock_not_enough';
    case PRODUCT_NOT_FOUND = 'product_not_found';
}
