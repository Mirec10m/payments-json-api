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

        /*
         * This is an example response from gateway API call
         */
        return [
            'status' => PaymentStatusEnum::CREATED,
            'metadata' => json_encode([
                'success' => true,
                'somethingElse' => 'Lorem ipsum',
                'callback_url' => $callback_url,
            ]),
            'message' => 'Payment was created successfully.',
        ];
    }
}
