<?php

namespace App\Enums\Address;

enum AddressDeleteStatus : string
{
    case NOT_FOUND = 'no_address';
    case HAS_ORDERS = 'exist_orders';
    case DELETED = 'deleted';
}
