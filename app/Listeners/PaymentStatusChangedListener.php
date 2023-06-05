<?php

namespace App\Listeners;

use App\Events\PaymentStatusChangedEvent;
use App\Notifications\PaymentStatusChangedNotification;

class PaymentStatusChangedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(PaymentStatusChangedEvent $event)
    {
        $event->payment->payment_logs()->create([
            'status' => $event->status,
            'metadata' => $event->metadata,
        ]);
        $event->payment->notify(new PaymentStatusChangedNotification());
    }
}
