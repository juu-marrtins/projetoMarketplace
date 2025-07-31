<?php

namespace App\Enums\Address;

class AddressDeleteStatus
{
    public const NOT_FOUND = 'no_address';
    public const HAS_ORDERS = 'exist_orders';
}
