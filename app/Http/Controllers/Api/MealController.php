<?php

namespace App\Http\Controllers\Api;

use App\Actions\IMenuItemsAction;

class MealController extends ApiBaseController
{
    public function __construct(protected IMenuItemsAction $menuItemsAction)
    {
    }

    public function __invoke()
    {
        $items = $this->menuItemsAction->handle();

        return $items ? $this->respondSuccess($items) : $this->respondNotFound();
    }
}
