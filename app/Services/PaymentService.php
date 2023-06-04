<?php

namespace App\Services;

use App\DTO\PaymentDTO;
use App\Enums\PaymentStatusEnum;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Carbon\Carbon;

class PaymentService
{
    public function createPayment(PaymentDTO $paymentDTO): PaymentResource
    {
        $payment = Payment::create($paymentDTO->toArray());
        $payment->expired_at = Carbon::now()->addDay();
        $payment->save();

        return new PaymentResource($payment);
    }

    public function makePayment(Payment $payment): string
    {
        if ($payment->status == PaymentStatusEnum::EXPIRED) {
            return 'Payment expired.';
        }

        // gateway -> make API call to pay
        $response = 'response msg';

        return $response;
    }
}
