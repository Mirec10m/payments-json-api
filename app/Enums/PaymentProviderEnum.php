<?php

namespace App\Enums;

use App\Gateways\StripeGateway;
use App\Interfaces\GatewayInterface;

enum PaymentProviderEnum: string
{
    case STRIPE = 'stripe';

    public function gateway(): GatewayInterface
    {
        return match ($this) {
            PaymentProviderEnum::STRIPE => new StripeGateway(),
        };
    }
}
