<?php

namespace App\Enums\Moderator;

class ProductDeleteStatus
{
    public const NOT_FOUND = 'no_products';
    public const HAS_ORDERS_ITEMS = 'has_orders_items';
    public const DELETED = 'deleted';
}
