<?php

namespace App\Enums\Admin;

enum DiscountDeleteStatus : string
{
    case NOT_FOUND = 'no_discount';
    case DELETED = 'deleted';
}