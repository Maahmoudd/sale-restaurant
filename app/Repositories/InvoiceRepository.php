<?php

namespace App\Repositories;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class InvoiceRepository implements IInvoiceRepository
{
    public function create(Order $order, float $total): Invoice
    {
        return $order->invoice()->create([
            'user_id' => Auth::user()->id,
            'customer_id' => $order->customer_id,
            'total' => $total
        ]);
    }
}
