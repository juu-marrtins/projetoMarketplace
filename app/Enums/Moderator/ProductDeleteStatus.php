<?php

namespace App\Enums\Moderator;

enum ProductDeleteStatus : string
{
    case NOT_FOUND = 'no_products';
    case HAS_ORDERS_ITEMS = 'has_orders_items';
    case DELETED = 'deleted';
}
