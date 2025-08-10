<?php

namespace App\Enums\Admin;

enum CouponDeleteStatus : string
{
    case NOT_FOUND = 'no_coupons';
    case HAS_ORDERS = 'has_orders';
    case DELETED = 'deleted';
}