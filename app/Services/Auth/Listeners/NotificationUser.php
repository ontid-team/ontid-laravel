<?php

namespace App\Services\Auth\Listeners;

use App\Services\Auth\Interfaces\IUserModel;
use App\Services\Auth\Resources\UserResource;

class NotificationUser
{
    public IUserModel $user;
    public string $domain;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(IUserModel $model)
    {
        dd($model);
        $this->user = $model;
        $this->domain = config('app.domain');
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        dd($event);
        $this->user->tokens()->whereIn('name', ['access_token', 'refresh_token'])->delete();
        $expires = now()->addDays(30)->diffInSeconds();
        setcookie('user', UserResource::make($this->user)->toJson(), time()+$expires, "/", $this->domain, 0, 0);
    }
}
