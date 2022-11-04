<?php

namespace App\Services\Auth;

use App\Models\Provider;
use App\Services\Auth\Interfaces\ISocialAuthenticate;
use App\Services\Auth\ValueObjects\User;
use DomainException;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthenticate implements ISocialAuthenticate
{
    private ?string $driver = null;
    private array $allowDrivers = [];

    public function setDriver(string $driver)
    {
        $this->driver = $driver;
    }

    public function getDriver(): ?string
    {
        return $this->driver;
    }

    public function isAllowedDriver()
    {
        if (!in_array($this->driver, $this->allowDrivers)) {
            throw new DomainException('social driver not allowed');
        }
    }

    public function redirect($provider)
    {
        Socialite::driver($provider)->redirect();
    }


    public function login(Provider $socialProvider, $request)
    {

        $user = Socialite::driver($socialProvider)->userFromToken($request->token);

        if (isset($user->id)) {
            $providerCheck = Provider::where('identity', $user->id)
                ->where('provider', $socialProvider)
                ->first();

            if (empty($providerCheck)) {
                $email = $user->accessTokenResponseBody['email'] ?? null;
                $email = $email ?: $user->email;
                $newUser = new User();
                $newUser->setName($user->name);
                $newUser->setPassword($socialProvider . '@' . $user->id . time());
                $newUser->setEmail($user->email);
                $newUser->setProvider($socialProvider, $user->id);
            } else {
                $authUser = $providerCheck->user()->first();
            }

        }
    }

    public function allowSocialDrivers(string ...$providers)
    {
        // TODO: Implement allowSocialDrivers() method.
    }
}
