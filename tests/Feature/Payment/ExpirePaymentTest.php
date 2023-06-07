<?php

namespace Tests\Feature\Payment;

use App\Enums\PaymentStatusEnum;
use App\Events\PaymentStatusChangedEvent;
use App\Jobs\ExpirePaymentJob;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ExpirePaymentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if Payment can expire.
     *
     * @return void
     */
    public function test_payment_can_expire(): void
    {
        Event::fake();

        $payment = Payment::factory()->create([
            'status' => PaymentStatusEnum::NEW->value,
            'expired_at' => Carbon::yesterday(),
        ]);

        $job = new ExpirePaymentJob();
        $job->handle();

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => PaymentStatusEnum::EXPIRED->value,
        ]);
    }

    /**
     * Test that Payment cannot expire if status is PAID.
     *
     * @return void
     */
    public function test_payment_cannot_expire_if_status_is_paid(): void
    {
        Event::fake();

        $payment = Payment::factory()->create([
            'status' => PaymentStatusEnum::PAID->value,
            'expired_at' => Carbon::yesterday(),
        ]);

        $job = new ExpirePaymentJob();
        $job->handle();

        $this->assertDatabaseMissing('payments', [
            'id' => $payment->id,
            'status' => PaymentStatusEnum::EXPIRED->value,
        ]);
    }

    /**
     * Test if PaymentStatusChangedEvent is being dispatched when Payment expires.
     *
     * @return void
     */
    public function test_event_dispatch_when_payment_expires(): void
    {
        Event::fake();

        Payment::factory()->create([
            'status' => PaymentStatusEnum::NEW->value,
            'expired_at' => Carbon::yesterday(),
        ]);

        $job = new ExpirePaymentJob();
        $job->handle();

        Event::assertDispatched(PaymentStatusChangedEvent::class);
    }
}
