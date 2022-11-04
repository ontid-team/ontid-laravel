<?php

namespace App\Providers;

use App\Classes\Macros\Builder\WhereCross;
use App\Enums\BuilderOperationEnum;
use App\Models\Appointment;
use App\Models\Schedule;
use App\Observers\AppointmentObserver;
use App\Observers\ScheduleObserver;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schedule::observe(ScheduleObserver::class);
        Appointment::observe(AppointmentObserver::class);
    }
}
