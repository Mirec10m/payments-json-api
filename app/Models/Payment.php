<?php

namespace App\Models;

use App\Enums\PaymentCurrencyEnum;
use App\Enums\PaymentProviderEnum;
use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Payment extends Model
{
    use HasFactory, Notifiable;

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
        'gateway_url',
    ];

    protected $casts = [
        'currency' => PaymentCurrencyEnum::class,
        'provider' => PaymentProviderEnum::class,
        'status' => PaymentStatusEnum::class,
    ];
}
