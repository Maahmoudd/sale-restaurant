<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    protected $model = Reservation::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'table_id' => Table::factory()->create()->id,
            'customer_id' => Customer::factory()->create()->id,
            'from_time' => $this->faker->dateTimeBetween('now', '+3 days'),
            'to_time' => $this->faker->dateTimeBetween('+4 days', '+7 days'),
        ];
    }
}
