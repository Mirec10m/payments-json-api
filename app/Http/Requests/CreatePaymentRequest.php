<?php

namespace App\Http\Requests;

use App\Enums\PaymentCurrencyEnum;
use App\Enums\PaymentProviderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreatePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'surname' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'address' => ['required', 'string'],
            'postal_code' => ['required', 'string'],
            'city' => ['required', 'string'],
            'amount' => ['required', 'numeric', 'between:0.00,99999999.99'],
            'currency' => ['required', new Enum(PaymentCurrencyEnum::class)],
            'provider' => ['required', new Enum(PaymentProviderEnum::class)]
        ];
    }
}
