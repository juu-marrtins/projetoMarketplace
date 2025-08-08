<?php

namespace App\Enums\Cart;

enum CartDeleteStatus : string
{
    case NOT_FOUND = 'not_found';
    case DELETED = 'deleted';
}
