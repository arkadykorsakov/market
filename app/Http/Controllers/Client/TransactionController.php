<?php

namespace App\Http\Controllers\Client;

use App\Enums\Order\OrderStatusEnum;
use App\Enums\Transaction\PaymentStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Exception;

class TransactionController extends Controller
{
    public function callback()
    {
        $source = file_get_contents('php://input');
        $requestBody = json_decode($source, true);

        try {
            $status = PaymentStatusEnum::valueIdMap()[$requestBody['event']] ?? PaymentStatusEnum::DEFAULT_VALUE->value;
            $transaction = Transaction::where('payment_uuid', $requestBody['object']['id'])->first();

            $transaction?->update([
                'status' => $status
            ]);

            if ($status === OrderStatusEnum::SUCCESS->value) {
                $transaction?->order->update([
                    'status' => OrderStatusEnum::SUCCESS->value
                ]);
            }

        } catch (Exception $e) {
            // Обработка ошибок при неверных данных
        }
    }
}
