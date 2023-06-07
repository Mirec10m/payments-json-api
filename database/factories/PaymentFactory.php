<?php

namespace Database\Factories;

use App\Enums\PaymentProviderEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Crypt;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => Crypt::encryptString(fake()->firstName),
            'surname' => Crypt::encryptString(fake()->lastName),
            'email' => fake()->email,
            'address' => Crypt::encryptString(fake()->streetAddress),
            'postal_code' => fake()->postcode,
            'city' => fake()->city,
            'amount' => fake()->numberBetween(10, 1000),
            'currency' => 'eur',
            'provider' => PaymentProviderEnum::STRIPE->value,
        ];
    }
}
