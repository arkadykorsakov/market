<?php

namespace App\Enums\Order;

enum OrderStatusEnum: int
{
    case CREATED = 1;
    case SUCCESS = 2;
    case CANCEL = 3;
}
