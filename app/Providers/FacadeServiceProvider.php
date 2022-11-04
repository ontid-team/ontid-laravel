<?php

namespace App\Providers;

use App\Classes\Facades\DynamicOperator\DynamicOperator;
use Illuminate\Support\ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('DynamicOperator', function() {
            return new DynamicOperator();
        });
    }
}
