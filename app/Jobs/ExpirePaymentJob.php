<?php

namespace App\Jobs;

use App\Enums\PaymentStatusEnum;
use App\Events\PaymentStatusChangedEvent;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExpirePaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $payments = Payment::where(function ($q) {
            $q->where('status', PaymentStatusEnum::NEW->value)
                ->orWhere('status', PaymentStatusEnum::CREATED->value)
                ->orWhereNull('status');
        })->where('expired_at', '<', Carbon::now())
            ->get();

        if ($payments->isNotEmpty()) {
            $payments->toQuery()->update(['status' => PaymentStatusEnum::EXPIRED]);

            $payments->map(function ($payment) {
                PaymentStatusChangedEvent::dispatch($payment, PaymentStatusEnum::EXPIRED);
            });
        }
    }
}
