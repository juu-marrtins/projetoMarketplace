<?php

namespace App\Enums;

class OrderCreateOrderStatus
{
    public const STOCK_NOT_ENOUGH = 'stock_not_enough';
    public const SUCCESS = 'success';
    public const DISCOUNT_INVALID = 'discount_invalid';
    public const CART_EMPTY = 'cart_empty';
    public const ORDER_ALREADY_CANCELED = 'order_already_canceled';
    public const ORDER_NOT_FOUND = 'order_not_found';
    public const ADDRESS_NOT_FOUND = 'address_not_found';
    public const ORDER_SUCCESS_WITHOUT_DISCOUNT = 'order_success_without_discount';
}