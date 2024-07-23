<?php

namespace Tests\Unit;

use App\Models\Customer;
use Tests\TestCase;
use App\Models\Table;
use App\Repositories\TableRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TableTest extends TestCase
{
    use RefreshDatabase;

    protected $tableRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tableRepository = new TableRepository();
    }

    public function test_get_available_table_finds_available_table()
    {
        $table = Table::factory()->create();

        $table->reservations()->create([
            'customer_id' => Customer::factory()->create()->id,
            'from_time' => '2024-07-23 10:00:00',
            'to_time' => '2024-07-23 12:00:00',
        ]);

        $availableTable = $this->tableRepository->getAvailableTable(
            $table->id,
            '2024-07-23 13:00:00',
            '2024-07-23 15:00:00',
            2
        );

        $this->assertNotNull($availableTable);
        $this->assertEquals($table->id, $availableTable->id);
    }

    public function test_get_available_table_finds_no_available_table()
    {
        $table = Table::factory()->create();

        $table->reservations()->create([
            'customer_id' => Customer::factory()->create()->id,
            'from_time' => '2024-07-23 10:00:00',
            'to_time' => '2024-07-23 12:00:00',
        ]);

        $availableTable = $this->tableRepository->getAvailableTable(
            $table->id,
            '2024-07-23 11:00:00',
            '2024-07-23 13:00:00',
            200
        );

        $this->assertNull($availableTable);
    }

    public function test_get_available_table_finds_table_based_on_capacity()
    {
        $table1 = Table::factory()->create();

        $table2 = Table::factory()->create();

        $table1->reservations()->create([
            'customer_id' => Customer::factory()->create()->id,
            'from_time' => '2024-07-23 10:00:00',
            'to_time' => '2024-07-23 12:00:00',
        ]);

        $availableTable = $this->tableRepository->getAvailableTable(
            $table2->id,
            '2024-07-23 13:00:00',
            '2024-07-23 15:00:00',
            2
        );

        $this->assertNotNull($availableTable);
        $this->assertEquals($table2->id, $availableTable->id);
    }
}
