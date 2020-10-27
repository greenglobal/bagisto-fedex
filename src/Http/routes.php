<?php

Route::group(['middleware' => ['web']], function () {
    Route::prefix(config('app.admin_url'))->group(function () {
        // Admin Routes
        Route::group(['middleware' => ['admin']], function () {
            // Sales Routes
            Route::prefix('sales')->group(function () {
                // Tracking Routes
                Route::get('tracking/{id}', 'GGPHP\Shipping\Http\Controllers\Tracking\TrackingController@view')->defaults('_config', [
                    'view' => 'ggphp-shipping::tracking.view',
                ]);
            });
        });
    });
});
