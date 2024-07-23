<?php

namespace App\Repositories;

use App\Models\Order;

interface IOrderDetailsRepository
{
    public function create(Order $order, array $items): float|int;
}
