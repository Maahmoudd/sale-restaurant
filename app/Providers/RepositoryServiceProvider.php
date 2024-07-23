<?php

namespace App\Providers;

use App\Repositories\IInvoiceRepository;
use App\Repositories\IMenuItemsRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\IOrderDetailsRepository;
use App\Repositories\IOrderRepository;
use App\Repositories\IReservationRepository;
use App\Repositories\ITableRepository;
use App\Repositories\IWaitingListRepository;
use App\Repositories\MenuItemsRepository;
use App\Repositories\OrderDetailsRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ReservationRepository;
use App\Repositories\TableRepository;
use App\Repositories\WaitingListRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(ITableRepository::class, TableRepository::class);
        $this->app->bind(IReservationRepository::class, ReservationRepository::class);
        $this->app->bind(IWaitingListRepository::class, WaitingListRepository::class);
        $this->app->bind(IMenuItemsRepository::class, MenuItemsRepository::class);
        $this->app->bind(IOrderRepository::class, OrderRepository::class);
        $this->app->bind(IOrderDetailsRepository::class, OrderDetailsRepository::class);
        $this->app->bind(IInvoiceRepository::class, InvoiceRepository::class);
    }
}
