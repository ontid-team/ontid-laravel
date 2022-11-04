<?php

namespace App\Services\Auth\ValueObjects;

use Illuminate\Support\Facades\Hash;

class Password
{
    public string $password;
    public string $salt;
    public ?string $hash = null;

    public function __construct(string $password)
    {
        $this->salt = md5(uniqid(rand(), true));
        $this->password = $password;
    }

    public function isEquals($passwordHash): bool
    {
        return Hash::check($this->password, $passwordHash);
    }

    public function getPasswordHash(): string
    {
        return $this->makeHash();
    }

    private function makeHash(): string
    {
        if (empty($this->hash)) {
            $this->hash = Hash::make($this->password, ['salt' => $this->salt]);
        }
        return $this->hash;
    }

    public function getSalt(): string
    {
        return $this->salt;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

}
