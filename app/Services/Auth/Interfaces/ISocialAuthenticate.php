<?php

namespace App\Services\Auth\Interfaces;

use App\Services\Auth\Enum\Provider;

interface ISocialAuthenticate
{
    public function login(Provider $provider, $request);
    public function allowSocialDrivers(string ...$providers);
    public function setDriver(string $driver);
    public function getDriver();
    public function redirect($provider);
}
