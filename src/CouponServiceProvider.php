<?php

namespace Ashadozzaman\Coupon;

use Illuminate\Support\ServiceProvider;

class CouponServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/coupon.php','coupon');
        $this->loadRoutesFrom(__DIR__.'/route/web.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations/');
        $this->loadViewsFrom(__DIR__.'/views','coupon');

        //publisher use for public something in main project
        $this->publishes([
            __DIR__.'/config/coupon.php' => config_path('coupon.php'),
            __DIR__.'/views' => resource_path('views/vendor/coupon')
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
