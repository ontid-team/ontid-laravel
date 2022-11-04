<?php

namespace App\Services\Auth\Dto;

use App\Services\Auth\Enum\Profile;
use App\Services\Auth\ValueObjects\Password;

class UserDto
{
    public string $name;
    public string $email;
    public Password $password;
    public ?Password $password_confirm;
    public ?Profile $type;
    /**
     * @param Profile $type
     */
    public function setType(Profile $type): void
    {
        $this->type = $type;
    }

    /**
     * @param Password $password_confirm
     */
    public function setPasswordConfirm(Password $password_confirm): void
    {
        $this->password_confirm = $password_confirm;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $name
     * @param string $email
     * @param Password $password
     */
    public function __construct(
        string $name,
        string $email,
        Password $password,
        Password $password_confirm = null
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->password_confirm = $password_confirm;

    }

    public static function fromRequest($request): static
    {
        return new static(
            $request->name,
            $request->email,
            new Password($request->password),
            new Password($request->password_confirm)
        );
    }

}
