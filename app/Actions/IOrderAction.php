<?php

namespace App\Actions;

use App\Models\Order;

interface IOrderAction
{
    public function handle(array $request);
}
