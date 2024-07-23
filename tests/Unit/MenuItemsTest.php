<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Meal;
use App\Repositories\MenuItemsRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class MenuItemsTest extends TestCase
{
    use RefreshDatabase;

    protected $menuItemsRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->menuItemsRepository = new MenuItemsRepository();
    }

    public function test_list_menu_items_returns_available_meals()
    {
        Meal::factory()->create(['available_quantity' => 5]); // Should be returned
        Meal::factory()->create(['available_quantity' => 0]); // Should not be returned
        Meal::factory()->create(['available_quantity' => 3]); // Should be returned

        $result = $this->menuItemsRepository->listMenuItems();

        $this->assertCount(2, $result);
        $this->assertGreaterThan(0, $result[0]->available_quantity);
        $this->assertGreaterThan(0, $result[1]->available_quantity);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
