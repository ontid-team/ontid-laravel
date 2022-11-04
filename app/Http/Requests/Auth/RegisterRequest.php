<?php

namespace App\Http\Requests\Auth;

use App\Classes\Abstracts\BaseRequest;
use App\Classes\Validation\Fields\EmailField;
use App\Classes\Validation\Fields\NameField;
use App\Classes\Validation\Fields\PasswordField;
use App\Classes\Validation\Fields\PhoneField;
use OpenApi\Attributes as OA;

/**
 * @property mixed $password_confirm
 */
#[OA\Schema(required: ['email', 'name', 'password', 'password_confirm'])]

class RegisterRequest extends BaseRequest
{

    #[OA\Property(property: 'email', type: 'string')]
    #[OA\Property(property: 'phone', type: 'string')]
    #[OA\Property(property: 'name', type: 'string')]
    #[OA\Property(property: 'password', type: 'string')]
    #[OA\Property(property: 'password_confirm', type: 'string')]
    protected function validators(): array
    {
        return [
            EmailField::options(required: true),
            NameField::options(required: true),
            PasswordField::class,
            PasswordField::options(
                name: 'password_confirm',
                required: true
            ),
            PhoneField::class,
        ];
    }
}
