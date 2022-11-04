<?php

namespace App\Http\Requests\Auth;

use App\Classes\Abstracts\BaseRequest;
use App\Classes\Validation\Fields\EmailField;
use App\Classes\Validation\Fields\PasswordField;
use OpenApi\Attributes as OA;

/**
 * @property mixed $email
 * @property mixed $password
 */
#[OA\Schema(required: ['email', 'password'])]
class LoginRequest extends BaseRequest
{
    #[OA\Property(property: 'email', type: 'string')]
    #[OA\Property(property: 'password', type: 'string')]
    protected function validators(): array
    {
        return [
            EmailField::options(required: true),
            PasswordField::class
        ];
    }
}
