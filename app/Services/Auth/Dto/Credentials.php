<?php

namespace App\Services\Auth\Dto;


use App\Services\Auth\ValueObjects\Password;

/**
 * @property string $email
 * @property Password $password
 */
class Credentials
{
    public string $email;
    public Password $password;
    public ?Password $password_confirm;
    public ?string $token;

    /**
     * @param string|null $email
     * @param string|Password $password
     * @param string|Password|null $password_confirm
     * @param string|null $token
     */
    public function __construct(
        string|Password $password,
        null|string|Password $password_confirm = null,
        ?string $email = null,
        ?string $token = null
    ) {
        $this->email = $email;
        $this->password = is_string($password) ? new Password($password) : $password;
        $this->password_confirm = is_string($password_confirm) ? new Password($password_confirm) : $password_confirm;
        $this->token = $token;
    }

    public function isPasswordConfirmed(): bool
    {
        return $this->password->getPassword() === $this->password_confirm->getPassword();
    }
}
