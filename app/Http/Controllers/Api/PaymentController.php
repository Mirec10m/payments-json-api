<?php

namespace App\Http\Controllers\Api;

use App\DTO\PaymentDTO;
use App\Http\Requests\CreatePaymentRequest;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;

class PaymentController extends BaseController
{
    public function __construct(private readonly PaymentService $paymentService)
    {
    }

    public function create(CreatePaymentRequest $request): JsonResponse
    {
        $paymentDTO = new PaymentDTO(...$request->validated());
        $payment = $this->paymentService->createPayment($paymentDTO);

        return $this->sendResponse($payment, 'Payment created.');
    }

    public function check(Payment $payment): JsonResponse
    {
        $msg = $this->paymentService->makePayment($payment);

        return $this->sendResponse($payment, $msg);
    }
}
