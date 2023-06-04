<?php

namespace App\Gateways;

use App\Enums\PaymentStatusEnum;
use App\Interfaces\GatewayInterface;
use App\Models\Payment;

class StripeGateway implements GatewayInterface
{
    public function pay(Payment $payment, string $callback_url): array
    {
        // TODO: Implement pay() method.
        // make call to gateway API
        // payment will be processed by call to gateway API
        return [
            'status' => PaymentStatusEnum::CREATED,
            'message' => 'Payment was created successfully.',
        ];
    }
}
