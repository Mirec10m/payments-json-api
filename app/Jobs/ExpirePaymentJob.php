<?php

namespace App\Jobs;

use App\Enums\PaymentStatusEnum;
use App\Models\Payment;
use App\Notifications\PaymentStatusChangedNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

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
            $q->where('status', '!=', PaymentStatusEnum::EXPIRED)
                ->where('status', '!=', PaymentStatusEnum::PAID)
                ->orWhereNull('status');
        })->where('expired_at', '<', Carbon::now());

        $paymentsToNotify = $payments->get();
        $payments->update(['status' => PaymentStatusEnum::EXPIRED]);

        Notification::send($paymentsToNotify, new PaymentStatusChangedNotification());
    }
}
