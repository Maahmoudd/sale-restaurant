<?php

namespace App\Repositories;

use App\Models\Order;

interface IOrderRepository
{
    public function find(int $id): ?Order;
    public function create(array $request): ?Order;
    public function updateTotalAfterDetails(Order $order, $itemsTotal): Order;
}
