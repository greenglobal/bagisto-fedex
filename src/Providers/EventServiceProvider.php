<?php

namespace GGPHP\Shipping\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(['bagisto.shop.layout.head'], function($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('ggphp-shipping::shop.style');
        });

        Event::listen(['bagisto.shop.layout.body.after'], function($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('ggphp-shipping::shop.script');
        });
    }
}
