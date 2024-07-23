<?php

namespace App\Providers;

use App\Actions\AuthAction;
use App\Actions\CheckAvailabilityAction;
use App\Actions\IAuthAction;
use App\Actions\ICheckAvailabilityAction;
use App\Actions\IMenuItemsAction;
use App\Actions\IOrderAction;
use App\Actions\IReservationAction;
use App\Actions\MenuItemsAction;
use App\Actions\OrderAction;
use App\Actions\ReservationAction;
use Illuminate\Support\ServiceProvider;

class ActionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(IAuthAction::class, AuthAction::class);
        $this->app->bind(ICheckAvailabilityAction::class, CheckAvailabilityAction::class);
        $this->app->bind(IReservationAction::class, ReservationAction::class);
        $this->app->bind(IMenuItemsAction::class, MenuItemsAction::class);
        $this->app->bind(IOrderAction::class, OrderAction::class);
    }
}
