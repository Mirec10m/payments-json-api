<?php

namespace Database\Factories;

use App\Enums\PaymentProviderEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'name' => fake()->firstName,
            'surname' => fake()->lastName,
            'email' => fake()->email,
            'address' => fake()->streetAddress,
            'postal_code' => fake()->postcode,
            'city' => fake()->city,
            'amount' => fake()->numberBetween(10, 1000),
            'currency' => 'eur',
            'provider' => PaymentProviderEnum::STRIPE->value,
        ];
    }
}
