<?php

namespace App\Repositories;

use App\Models\Meal;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderDetailsRepository implements IOrderDetailsRepository
{
    public function create(Order $order, array $items): float|int
    {
        $total = 0;

        // Check meal availability before starting the transaction
        foreach ($items as $item) {
            $meal = Meal::find($item['meal_id']);
            if (!$meal || $meal->available_quantity < $item['quantity']) {
                return false;
            }
        }

        DB::beginTransaction();

        try {
            foreach ($items as $item) {
                $meal = Meal::find($item['meal_id']);
                $mealPrice = $this->calculateMealPrice($meal->price, $meal->discount, $item['quantity']);
                $total += $mealPrice;

                $orderDetail = $order->orderDetails()->create([
                    'meal_id' => $meal->id,
                    'quantity' => $item['quantity'],
                    'amount_to_pay' => $mealPrice,
                ]);

                $this->updateMealQuantity($meal, $item['quantity']);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        return $total;
    }

    private function calculateMealPrice(float $price, float $discount, int $quantity): float
    {
        return ($price * $quantity) * (1 - $discount / 100);
    }

    private function updateMealQuantity(Meal $meal, int $quantity): void
    {
        $meal->available_quantity -= $quantity;
        $meal->save();
    }
}
