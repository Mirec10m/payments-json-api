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
    ) {

    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'address' => $this->address,
            'postal_code' => $this->postal_code,
            'city' => $this->city,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'provider' => $this->provider,
        ];
    }
}
