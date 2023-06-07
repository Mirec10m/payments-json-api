<?php

namespace Tests\Feature\Payment;

use App\Enums\PaymentStatusEnum;
use App\Http\Middleware\ValidateSignature;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CallbackPaymentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if data can be processed on Payment callback URL.
     */
    public function test_data_can_be_processed_on_payment_callback_url(): void
    {
        Event::fake();

        $payment = Payment::factory()->create([
            'status' => PaymentStatusEnum::CREATED->value,
            'expired_at' => Carbon::tomorrow(),
        ]);

        $data = [
            'status' => 'paid',
            'metadata' => [
                'success' => true,
                'something' => 'Lorem ipsum',
                'somethingElse' => 'Lorem ipsum dolor',
            ],
        ];

        $response = $this->withoutMiddleware(ValidateSignature::class)
            ->post('/api/payments/callback/'.$payment->id, $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => PaymentStatusEnum::PAID->value,
        ]);
    }
}
