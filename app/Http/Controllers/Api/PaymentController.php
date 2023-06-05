<?php

namespace App\Http\Controllers\Api;

use App\DTO\PaymentDTO;
use App\Http\Requests\CreatePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Interfaces\GatewayInterface;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends BaseController
{
    public function __construct(private readonly PaymentService $paymentService)
    {
    }

    public function create(CreatePaymentRequest $request): JsonResponse
    {
        $paymentDTO = new PaymentDTO(...$request->validated());
        $data = $this->paymentService->createPayment($paymentDTO);

        return $this->sendResponse($data, 'Payment created.');
    }

    public function check(Payment $payment, GatewayInterface $gateway): JsonResponse
    {
        $response = $this->paymentService->makePayment($payment, $gateway);

        return $this->sendResponse(new PaymentResource($payment), $response['message']);
    }

    public function callback(Payment $payment, Request $request): JsonResponse
    {
        $this->paymentService->processPayment($payment, $request);

        return $this->sendResponse(null, 'Payment was processed.');
    }
}
