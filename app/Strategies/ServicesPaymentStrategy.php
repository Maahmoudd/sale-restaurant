<?php

namespace App\Strategies;

use App\Enums\OrderPaidEnum;
use App\Exceptions\OrderNotFoundException;
use App\Exceptions\OrderPaidException;
use App\Http\Resources\InvoiceResource;
use App\Repositories\IInvoiceRepository;
use App\Repositories\IOrderRepository;

class ServicesPaymentStrategy implements IPaymentStrategy
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
        $serviceRate = config('taxes.service_only');

        return $total * (1 + $serviceRate);
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
