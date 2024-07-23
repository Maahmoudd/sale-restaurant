<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository implements IOrderRepository
{

    public function find(int $id): ?Order
    {
        return Order::find($id);
    }
    public function create(array $request): ?Order
    {
        return Order::create([
            'table_id' => $request['table_id'],
            'reservation_id' => $request['reservation_id'],
            'customer_id' => $request['customer_id'],
            'user_id' => $request['user_id'],
            'date' => now()
        ]);
    }

    public function updateTotalAfterDetails(Order $order, $itemsTotal): Order
    {
        $order->total = $itemsTotal;
        $order->save();
        return $order;
    }
}
