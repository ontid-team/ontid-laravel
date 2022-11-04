<?php

namespace App\Services\Auth\Interfaces;

interface ISocialAuthenticateRequest
{
    public function getToken();
}
