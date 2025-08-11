<?php

namespace App\Enums\CartItems;

enum CartItemsCartStatus : string
{
    case CART_NOT_FOUND = 'cart_not_found';
    case NO_ITEMS = 'no_items';
}
