<?php

namespace App\Enums\Admin;

class CouponDeleteStatus{
    public const NOT_FOUND = 'no_coupons';
    public const HAS_ORDERS = 'has_orders';
    public const DELETED = 'deleted';
}