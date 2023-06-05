<?php

namespace App\Enums;

enum PaymentStatusEnum: string
{
    case NEW = 'new';
    case CREATED = 'created';
    case PAID = 'paid';
    case FAILED = 'failed';
    case EXPIRED = 'expired';
}
