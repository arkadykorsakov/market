<?php

namespace App\Enums\Transaction;

enum PaymentStatusEnum: string
{

    case DEFAULT_VALUE = 'pending';

    /** Успешно оплачен покупателем, ожидает подтверждения магазином */
    case PAYMENT_WAITING_FOR_CAPTURE = 'payment.waiting_for_capture';

    /** Успешно оплачен и подтвержден магазином */
    case PAYMENT_SUCCEEDED = 'payment.succeeded';

    /** Неуспех оплаты или отменен магазином */
    case PAYMENT_CANCELED = 'payment.canceled';

    public static function valueIdMap(): array
    {
        return [
            self::DEFAULT_VALUE->value => 0,
            self::PAYMENT_WAITING_FOR_CAPTURE->value => 1,
            self::PAYMENT_SUCCEEDED->value => 2,
            self::PAYMENT_CANCELED->value => 3,
        ];
    }

}
