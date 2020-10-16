<?php

namespace GGPHP\Shipping\Providers;

use Illuminate\Support\ServiceProvider;

class ShippingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('vendor/ggphp/shipping/assets'),
        ], 'public');

        $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'ggphp');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'ggphp-shipping');

        $this->app->register(EventServiceProvider::class);

        $this->app->register(FedExServiceProvider::class);
    }
}
