<?php

namespace App\Services;

use App\DTO\PaymentDTO;
use App\Enums\PaymentStatusEnum;
use App\Events\PaymentStatusChangedEvent;
use App\Interfaces\GatewayInterface;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class PaymentService
{
    public function createPayment(PaymentDTO $paymentDTO): array
    {
        $payment = Payment::create($paymentDTO->toArray());
        $payment->expired_at = Carbon::now()->addDay();
        $payment->status = PaymentStatusEnum::NEW;
        $payment->save();

        PaymentStatusChangedEvent::dispatch($payment, PaymentStatusEnum::NEW);

        return [
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'redirect_url' => URL::signedRoute('check_expired', $payment),
        ];
    }

    public function makePayment(Payment $payment, GatewayInterface $gateway): array
    {
        if ($payment->status == PaymentStatusEnum::EXPIRED) {
            return ['message' => 'Payment expired.'];
        }

        $response = $gateway->pay($payment, URL::signedRoute('callback_url', $payment));
        $payment->update(['status' => $response['status']]);

        PaymentStatusChangedEvent::dispatch($payment, $response['status'], $response['metadata']);

        return $response;
    }

    public function processPayment(Payment $payment, Request $request): void
    {
        $payment->update(['status' => PaymentStatusEnum::from($request->status)]);

        PaymentStatusChangedEvent::dispatch($payment, $payment->status, $request->metadata);
    }
}
