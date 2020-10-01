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
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'ggphp');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'ggphp-shipping');

        $this->app->register(FedExServiceProvider::class);
    }
}
