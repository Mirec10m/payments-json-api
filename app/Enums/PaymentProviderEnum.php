<?php

namespace App\Enums;

enum PaymentProviderEnum: string
{
    case GOPAY = 'gopay';
    case STRIPE = 'stripe';
}
