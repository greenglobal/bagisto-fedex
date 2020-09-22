<?php

namespace GGPHP\Shipping\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use GGPHP\Shipping\Shipping;
use GGPHP\Shipping\Facades\Shipping as ShippingFacade;

class FedExServiceProvider extends ServiceProvider {

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__ . '/../Http/helpers.php';
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFacades();

        $this->registerConfig();
    }

    /**
     * Register Bouncer as a singleton.
     *
     * @return void
     */
    protected function registerFacades()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('shipping', ShippingFacade::class);

        $this->app->singleton('shipping', function () {
            return new Shipping();
        });
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/carriers.php', 'carriers');

        $this->mergeConfigFrom(__DIR__ . '/../config/system.php', 'core');
    }
}
