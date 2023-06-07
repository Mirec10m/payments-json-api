<?php

namespace Tests\Feature\Payment;

use App\Enums\PaymentStatusEnum;
use App\Events\PaymentStatusChangedEvent;
use App\Http\Middleware\ValidateSignature;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PaymentStatusChangedEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if PaymentStatusChangedEvent can be dispatched when Payment status changes.
     */
    public function test_event_is_dispatched_when_status_changes(): void
    {
        Event::fake();

        $user = User::factory()->create();
        $payment = Payment::factory()->create([
            'status' => PaymentStatusEnum::NEW->value,
            'expired_at' => Carbon::tomorrow(),
        ]);

        Sanctum::actingAs($user);

        $response = $this->withoutMiddleware(ValidateSignature::class)
            ->get('/api/payments/check/'.$payment->id);

        Event::assertDispatched(PaymentStatusChangedEvent::class);

        $response->assertStatus(200);
    }
}
