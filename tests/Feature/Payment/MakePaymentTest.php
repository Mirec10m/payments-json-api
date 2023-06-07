<?php

namespace Tests\Feature\Payment;

use App\Enums\PaymentStatusEnum;
use App\Http\Middleware\ValidateSignature;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MakePaymentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if Payment can be made.
     *
     * @return void
     */
    public function test_payment_can_be_made(): void
    {
        $user = User::factory()->create();
        $payment = Payment::factory()->create([
            'status' => PaymentStatusEnum::NEW,
            'expired_at' => Carbon::now()->addDay(),
        ]);

        Sanctum::actingAs($user);

        $response = $this->withoutMiddleware(ValidateSignature::class)
            ->get('/api/payments/check/' . $payment->id);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $payment->id,
            ]
        ]);
    }

    /**
     * Test that Payment can not be made if Payment has status EXPIRED
     *
     * @return void
     */
    public function test_payment_cannot_be_made_if_expired(): void
    {
        $user = User::factory()->create();
        $payment = Payment::factory()->create([
            'status' => PaymentStatusEnum::EXPIRED,
        ]);

        Sanctum::actingAs($user);

        $response = $this->withoutMiddleware(ValidateSignature::class)
            ->get('/api/payments/check/' . $payment->id);

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'status' => PaymentStatusEnum::EXPIRED->value,
            ],
            'message' => 'Payment expired.',
        ]);
    }
}
