<?php

namespace Database\Factories;

use App\Models\Meal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Meal>
 */
class MealFactory extends Factory
{
    protected $model = Meal::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price' => $this->faker->randomFloat(2, 5, 50),
            'description' => $this->faker->sentence(6),
            'available_quantity' => $this->faker->numberBetween(1, 100),
            'discount' => $this->faker->randomFloat(2, 0, 10),
        ];
    }
}
