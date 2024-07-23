<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Exceptions\OrderNotFoundException;
use App\Exceptions\OrderPaidException;
use App\Repositories\IInvoiceRepository;
use App\Repositories\IOrderRepository;
use App\Strategies\ServicesPaymentStrategy;
use App\Models\Order;

class CheckoutTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRepository = Mockery::mock(IOrderRepository::class);
        $this->invoiceRepository = Mockery::mock(IInvoiceRepository::class);
        $this->strategy = new ServicesPaymentStrategy($this->orderRepository, $this->invoiceRepository);
    }

    public function test_pay_throws_order_not_found_exception()
    {
        $orderId = 999;

        $this->orderRepository
            ->shouldReceive('find')
            ->once()
            ->with($orderId)
            ->andReturn(null);

        $this->expectException(OrderNotFoundException::class);

        $data = ['order_id' => $orderId];
        $this->strategy->pay($data);
    }

    public function test_pay_throws_order_paid_exception()
    {
        $order = Mockery::mock(Order::class);
        $order->shouldReceive('getAttribute')->with('id')->andReturn(1);
        $order->shouldReceive('getAttribute')->with('paid')->andReturn(true);

        $this->orderRepository
            ->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn($order);

        $this->expectException(OrderPaidException::class);

        $data = ['order_id' => 1];
        $this->strategy->pay($data);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
