<?php

namespace App\Strategies;

use App\Enums\OrderPaidEnum;
use App\Exceptions\OrderNotFoundException;
use App\Exceptions\OrderPaidException;
use App\Http\Resources\InvoiceResource;
use App\Repositories\IInvoiceRepository;
use App\Repositories\IOrderRepository;

class TaxesPaymentStrategy implements IPaymentStrategy
{
    public function __construct(
        protected IOrderRepository $orderRepository,
        protected IInvoiceRepository $invoiceRepository
    )
    {
    }

    public function pay(array $data)
    {
        $order = $this->orderRepository->find($data['order_id']);
        if (!$order) {
            throw new OrderNotFoundException($data['order_id']);
        }

        if ($order->paid) {
            throw new OrderPaidException($data['order_id']);
        }

        $total = $this->calculateTotal($order);
        $invoice = $this->createInvoice($order, $total);
        $this->updateOrderAndMarkPaid($order);
        return InvoiceResource::make($invoice);
    }

    private function calculateTotal($order)
    {
        $total = number_format($order->total, 2);

        $service = config('taxes.service_rate');
        $tax = config('taxes.tax_rate');
        return $total * $service * $tax;
    }

    private function createInvoice($order, $total)
    {
        return $this->invoiceRepository->create($order, $total);
    }

    private function updateOrderAndMarkPaid($order)
    {
        $order->update(['paid' => OrderPaidEnum::PAID->value]);
    }
}
