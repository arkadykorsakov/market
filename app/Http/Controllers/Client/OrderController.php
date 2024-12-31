<?php

namespace App\Http\Controllers\Client;

use App\Components\Yookassa;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Order\StoreRequest;
use App\Http\Resources\Order\OrderWithCartResource;
use App\Models\Order;
use App\Models\Transaction;
use App\Services\OrderService;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    public function store(StoreRequest $request)
    {
        $order = OrderService::store();
        return redirect()->route('client.orders.transactions.create', $order->id);
    }

    public function createTransaction(Order $order)
    {
        $order = OrderWithCartResource::make($order)->resolve();
        return inertia('Client/Order/CreateTransaction', compact('order'));
    }

    public function storeTransaction(Order $order)
    {
        try {
            $payment = Yookassa::make()->storePayment($order);
            $order->transaction()->create([
                'amount' => $order->total_sum,
                'youkassa_amount' => $payment->amount->value,
                'payment_uuid' => $payment->id,
            ]);
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            abort($exception->getCode() . $exception->getMessage());
        }

        return response('', Response::HTTP_CONFLICT)
            ->header('X-Inertia-Location', $payment->confirmation->confirmation_url);
    }
}
