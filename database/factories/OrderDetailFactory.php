<?php

namespace Database\Factories;

use App\Models\Meal;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderDetail>
 */
class OrderDetailFactory extends Factory
{
    protected $model = OrderDetail::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory()->create()->id,
            'meal_id' => Meal::factory()->create()->id,
            'amount_to_pay' => $this->faker->randomFloat(2, 5, 50),
            'quantity' => $this->faker->randomNumber(2, 5),
        ];
    }
}
