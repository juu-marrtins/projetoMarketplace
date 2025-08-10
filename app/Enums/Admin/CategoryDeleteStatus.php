<?php

namespace App\Enums\Admin;

enum CategoryDeleteStatus : string
{
    case NOT_FOUND = 'no_categories';
    case HAS_PRODUCTS = 'has_products';
    case DELETED = 'deleted';
}
