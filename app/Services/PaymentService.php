<?php

namespace App\Services;

use App\DTO\PaymentDTO;
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
}
