<?php

namespace App\Actions;

use App\Http\Resources\MealResource;
use App\Repositories\IMenuItemsRepository;

class MenuItemsAction implements IMenuItemsAction
{
    public function __construct(protected IMenuItemsRepository $menuItemsRepository)
    {
    }

    public function handle()
    {
        return MealResource::collection($this->menuItemsRepository->listMenuItems());
    }
}
