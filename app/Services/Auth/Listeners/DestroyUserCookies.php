<?php

namespace App\Services\Auth\Listeners;

use App\Services\Auth\Interfaces\IUserModel;
use App\Services\Auth\Resources\UserResource;

class DestroyUserCookies
{
    public string $config;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->config = config('app.domain');
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        setcookie('access_token', '', -1, "/", $this->config, 0, 0);
        setcookie('refresh_token', '', -1, "/", $this->config, 0, 0);
        setcookie('user', '', -1, "/", $this->config, 0, 0);
    }
}
