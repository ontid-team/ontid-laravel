<?php

namespace App\Services;

use App\Services\Auth\AuthService;
use App\Services\Auth\Events\LoggedInSuccess;
use App\Services\Auth\Events\RegisterSuccess;
use App\Services\Auth\Interfaces\IAuthService;
use App\Services\Auth\Interfaces\IProviderRepository;
use App\Services\Auth\Interfaces\ISocialAuthenticate;
use App\Services\Auth\Interfaces\IUserRepository;
use App\Services\Auth\Listeners\NotificationUser;
use App\Services\Auth\Listeners\SetUserCookies;
use App\Services\Auth\Repositories\ProviderRepository;
use App\Services\Auth\Repositories\UserRepository;
use App\Services\Auth\SocialAuthenticate;
use Event;
use Illuminate\Support\ServiceProvider;

class ServicesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ISocialAuthenticate::class, SocialAuthenticate::class);
        $this->app->bind(IAuthService::class, AuthService::class);
        $this->app->bind(IUserRepository::class,  UserRepository::class);
        $this->app->bind(IProviderRepository::class,  ProviderRepository::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(
            LoggedInSuccess::class, [
                SetUserCookies::class
            ]
        );
        Event::listen(
            RegisterSuccess::class, [
                NotificationUser::class
            ]
        );

    }
}
