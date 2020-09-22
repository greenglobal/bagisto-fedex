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
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'ggphp');

        $this->app->register(FedExServiceProvider::class);
    }
}
