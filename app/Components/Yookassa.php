<?php

namespace App\Components;

use App\Models\Order;
use YooKassa\Client;
use YooKassa\Request\Payments\CreatePaymentResponse;

class Yookassa
{
    private static Client $client;

    public function storePayment(Order $order): CreatePaymentResponse
    {
        return self::$client->createPayment(
            array(
                'amount' => array(
                    'value' => $order->total_sum,
                    'currency' => 'RUB',
                ),
                'confirmation' => array(
                    'type' => 'redirect',
                    'return_url' => url('categories'),
                ),
                'capture' => true,
                'description' => 'Заказ id ' . $order->id,
            ),
            uniqid('', true)
        );
    }

    public static function make(): Yookassa
    {
        self::$client = new Client();
        self::$client->setAuth(config('youkassa.shop_id'), config('youkassa.key'));
        return new self();
    }
}
