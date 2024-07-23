<?php

namespace App\Enums;

enum CheckoutStrategyEnum: int
{
    case TAXES_AND_SERVICES_STRATEGY = 1;
    case SERVICES_ONLY_STRATEGY = 2;
}
