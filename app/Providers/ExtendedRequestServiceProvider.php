<?php

namespace App\Providers;

use App\Http\Requests\GetCalendarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class ExtendedRequestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
//        $this->app->resolving(GetCalendarRequest::class, function ($request, $app) {
//            return GetCalendarRequest::createFrom($app['request'], $request);
//        });
    }
}
