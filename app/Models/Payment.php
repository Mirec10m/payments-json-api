<?php

namespace App\Models;

use App\Enums\PaymentCurrencyEnum;
use App\Enums\PaymentProviderEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'address',
        'postal_code',
        'city',
        'amount',
        'currency',
        'status',
        'provider',
        'expired_at',
        'gateway_transaction_id',
        'gateway_url'
    ];

    protected $casts = [
        'currency' => PaymentCurrencyEnum::class,
        'provider' => PaymentProviderEnum::class,
    ];
}
