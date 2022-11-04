<?php

namespace App\Services\Auth\Interfaces;

interface IUserRepository
{
    public function getUserByEmail(string $email);

}
