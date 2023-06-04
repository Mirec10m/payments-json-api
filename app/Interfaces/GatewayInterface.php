<?php

namespace App\Interfaces;

use App\Models\Payment;

interface GatewayInterface
{
    public function pay(Payment $payment, string $callback_url): array;
}
