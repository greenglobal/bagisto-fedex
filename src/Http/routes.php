<?php

// Admin Routes
Route::group(['middleware' => ['web']], function () {
    Route::prefix(config('app.admin_url'))->group(function () {
        // Admin Routes
        Route::group(['namespace' => 'GGPHP\Shipping\Http\Controllers\Admin', 'middleware' => ['admin']], function () {
            // Sales Routes
            Route::prefix('sales')->group(function () {
                // Tracking Routes
                Route::get('tracking/{id}', 'TrackingController@view')->defaults('_config', [
                    'view' => 'ggphp-shipping::admin.tracking.view',
                ]);
            });
        });
    });
});

// Shop Routes
Route::group(['middleware' => ['web', 'locale', 'theme', 'currency']], function () {
    Route::namespace('GGPHP\Shipping\Http\Controllers\Shop')->group(function () {
        // Customer routes
        Route::prefix('customer')->group(function () {
            // Auth Routes
            Route::group(['middleware' => ['customer']], function () {
                // Customer account
                Route::prefix('account')->group(function () {
                    Route::get('orders/{id}/tracking', 'TrackingController@view')->defaults('_config', [
                        'view' => 'ggphp-shipping::shop.tracking.view'
                    ])->name('customer.orders.tracking');
                });
            });
        });
    });
});

// API Routes
Route::group(['prefix' => 'api'], function ($router) {
    Route::group(['namespace' => 'GGPHP\Shipping\Http\Controllers\API',
        'middleware' => ['locale', 'theme', 'currency']], function ($router)
    {
        Route::get('tracking/{id}', 'TrackingController@get')->defaults('_config', [
            'authorization_required' => true
        ]);
    });
});
