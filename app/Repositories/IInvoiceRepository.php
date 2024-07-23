<?php

namespace App\Repositories;

use App\Models\Invoice;
use App\Models\Order;

interface IInvoiceRepository
{
    public function create(Order $order, float $total): Invoice;
}
