<?php

namespace App\Enums;

enum PaymentStatusEnum: string
{
    case CREATED = 'created';
    case PAID = 'paid';
    case FAILED = 'failed';
    case EXPIRED = 'expired';
}
