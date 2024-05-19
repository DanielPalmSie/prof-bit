<?php

namespace App\Enum;

use InvalidArgumentException;

enum ProductType: string
{
    case TYPE_1 = 'type-1';
    case TYPE_2 = 'type-2';
    case TYPE_3 = 'type-3';
}