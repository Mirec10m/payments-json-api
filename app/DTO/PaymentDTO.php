<?php

namespace App\DTO;

class PaymentDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $surname,
        public readonly string $email,
        public readonly string $address,
        public readonly string $postal_code,
        public readonly string $city,
        public readonly string $amount,
        public readonly string $currency,
        public readonly string $provider
    )
    {

    }
}
