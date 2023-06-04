<?php

namespace App\Http\Controllers\Api;

use App\DTO\PaymentDTO;
use App\Http\Requests\CreatePaymentRequest;
use App\Interfaces\GatewayInterface;
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

    public function check(Payment $payment, GatewayInterface $gateway): JsonResponse
    {
        $response = $this->paymentService->makePayment($payment, $gateway);

        return $this->sendResponse($payment, $response['message']);
    }
}
