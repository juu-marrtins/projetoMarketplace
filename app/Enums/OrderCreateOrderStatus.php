<?php

namespace App\Enums;

enum OrderCreateOrderStatus : string
{
    case STOCK_NOT_ENOUGH = 'stock_not_enough';
    case SUCCESS = 'success';
    case DISCOUNT_INVALID = 'discount_invalid';
    case CART_EMPTY = 'cart_empty';
    case ORDER_ALREADY_CANCELED = 'order_already_canceled';
    case ORDER_NOT_FOUND = 'order_not_found';
    case ADDRESS_NOT_FOUND = 'address_not_found';
    case ADDRESS_FOUND = 'address_found';
    case ORDER_SUCCESS_WITHOUT_DISCOUNT = 'order_success_without_discount';
    case CART_NOT_FOUND = 'cart_not_found';
}