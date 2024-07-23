<?php

namespace App\Repositories;

use App\Models\Meal;

class MenuItemsRepository implements IMenuItemsRepository
{
    public function listMenuItems()
    {
        return Meal::query()->where('available_quantity', '>', 0)->get();
    }
}
