<?php

namespace App\Services\Auth\Interfaces;

use App\Services\Auth\Dto\Credentials;
use App\Services\Auth\Dto\ProviderDto;
use App\Services\Auth\Dto\UserDto;

interface IAuthService
{
    public function verify(IVerifyRequest $request);
    public function logout();
    public function forgot(IForgotRequest $request);
    public function reset(Credentials $credentials);
    public function login(Credentials $login): IUserModel;
    public function register(UserDto $user, ProviderDto $provider): IUserModel;
    public function createAccessToken($user);
    public function createRefreshToken($user);
    public function createTokens($user);
}
