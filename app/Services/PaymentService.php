<?php

namespace App\Services;

use App\DTO\PaymentDTO;
use App\Enums\PaymentStatusEnum;
use App\Events\PaymentStatusChangedEvent;
use App\Http\Resources\PaymentResource;
use App\Interfaces\GatewayInterface;
use App\Models\Payment;
use App\Notifications\PaymentStatusChangedNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentService
{
    public function createPayment(PaymentDTO $paymentDTO): PaymentResource
    {
        $payment = Payment::create($paymentDTO->toArray());
        $payment->expired_at = Carbon::now()->addDay();
        $payment->status = PaymentStatusEnum::NEW;
        $payment->save();

        PaymentStatusChangedEvent::dispatch($payment, PaymentStatusEnum::NEW);

        return new PaymentResource($payment);
    }

    public function makePayment(Payment $payment, GatewayInterface $gateway): array
    {
        if ($payment->status == PaymentStatusEnum::EXPIRED) {
            return ['message' => 'Payment expired.'];
        }

        $response = $gateway->pay($payment, route('callback_url', $payment));
        $payment->update(['status' => $response['status']]);

        PaymentStatusChangedEvent::dispatch($payment, $response['status'], $response['metadata']);

        return $response;
    }

    public function processPayment(Payment $payment, Request $request): void
    {
        $payment->status = PaymentStatusEnum::from($request->status);

        PaymentStatusChangedEvent::dispatch($payment, $request->status, $request->metadata);
    }
}
