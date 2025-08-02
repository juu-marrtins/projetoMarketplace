<?php

namespace App\Enums\Admin;

class CategoryDeleteStatus
{
    public const NOT_FOUND = 'no_categories';
    public const HAS_PRODUCTS = 'has_products';
    public const DELETED = 'deleted';
}
