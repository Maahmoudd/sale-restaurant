<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Models\Table;
use Tests\TestCase;
use App\Models\Reservation;
use App\Repositories\ReservationRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    protected $reservationRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->reservationRepository = new ReservationRepository();
    }

    public function test_get_existing_reservation_finds_no_reservation()
    {
        $reservation = $this->reservationRepository->getExistingReservation(
            1,
            '2024-07-23 13:00:00',
            '2024-07-23 15:00:00'
        );

        $this->assertNull($reservation);
    }

    public function test_create_reservation_creates_new_reservation()
    {
        $data = [
            'table_id' => Table::factory()->create()->id,
            'customer_id' => Customer::factory()->create()->id,
            'from_time' => '2024-07-23 14:00:00',
            'to_time' => '2024-07-23 16:00:00',
        ];

        $reservation = $this->reservationRepository->createReservation($data);

        $this->assertInstanceOf(Reservation::class, $reservation);
        $this->assertEquals($data['table_id'], $reservation->table_id);
        $this->assertEquals($data['from_time'], $reservation->from_time);
        $this->assertEquals($data['to_time'], $reservation->to_time);
        $this->assertEquals($data['customer_id'], $reservation->customer_id);
    }
}
