<?php

namespace App\Providers;

use App\Enums\CheckoutStrategyEnum;
use App\Strategies\IPaymentStrategy;
use App\Strategies\ServicesPaymentStrategy;
use App\Strategies\TaxesPaymentStrategy;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(ActionServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->bind(IPaymentStrategy::class, function ($app) {
            $paymentMethod = request()->input('payment_method');
            return match ($paymentMethod) {
                CheckoutStrategyEnum::TAXES_AND_SERVICES_STRATEGY->value => $app->make(TaxesPaymentStrategy::class),
                CheckoutStrategyEnum::SERVICES_ONLY_STRATEGY->value => $app->make(ServicesPaymentStrategy::class),
                default => throw new \InvalidArgumentException('Invalid payment method'),
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }
}
