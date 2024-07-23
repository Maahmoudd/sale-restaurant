<?php

namespace App\Actions;

use App\Http\Resources\OrderResource;
use App\Models\Meal;
use App\Repositories\IOrderDetailsRepository;
use App\Repositories\IOrderRepository;
use Illuminate\Support\Facades\DB;

class OrderAction implements IOrderAction
{
    public function __construct(
        protected IOrderRepository $orderRepository,
        protected IOrderDetailsRepository $orderDetailsRepository
    )
    {
    }

    public function handle(array $request): ?OrderResource
    {
        foreach ($request['order_items'] as $item) {
            $meal = Meal::find($item['meal_id']);
            if (!$meal || $meal->available_quantity < $item['quantity']) {
                return null;
            }
        }

        DB::beginTransaction();

        try {
            $order = $this->orderRepository->create($request);
            if (!$order) {
                DB::rollBack();
                return null;
            }

            $itemsTotal = $this->orderDetailsRepository->create($order, $request['order_items']);
            if ($itemsTotal === false) {
                DB::rollBack();
                return null;
            }

            $order = $this->orderRepository->updateTotalAfterDetails($order, $itemsTotal);

            DB::commit();
            return OrderResource::make($order->load('table', 'reservation', 'customer', 'user', 'orderDetails'));
        } catch (\Exception $e) {
            DB::rollBack();
            return null;
        }
    }
}
