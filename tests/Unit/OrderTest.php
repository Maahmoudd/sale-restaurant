<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected $orderRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderRepository = new OrderRepository();
    }

    public function test_find_returns_order()
    {
        $order = Order::factory()->create();

        $result = $this->orderRepository->find($order->id);

        $this->assertInstanceOf(Order::class, $result);
        $this->assertEquals($order->id, $result->id);
    }

    public function test_updateTotalAfterDetails_updates_order_total()
    {
        $order = Order::factory()->create();

        $updatedOrder = $this->orderRepository->updateTotalAfterDetails($order, 150.00);

        $this->assertEquals(150.00, $updatedOrder->total);
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'total' => 150.00,
        ]);
    }
}
