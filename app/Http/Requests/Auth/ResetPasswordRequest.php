<?php

namespace App\Http\Requests\Auth;

use App\Classes\Abstracts\BaseRequest;
use App\Classes\Validation\Fields\PasswordField;
use OpenApi\Attributes as OA;

/**
 * @property mixed $password_confirm
 * @property mixed $password
 */
#[OA\Schema(required: ['password', 'password_confirm', 'token'])]
class ResetPasswordRequest extends BaseRequest
{
    #[OA\Property(property: 'password', type: 'string')]
    #[OA\Property(property: 'password_confirm', type: 'string')]
    #[OA\Property(property: 'token', type: 'string')]

    protected function validators(): array
    {
        return [
            PasswordField::class,
            PasswordField::options(name: 'password_confirm')
        ];
    }

    public function rules()
    {
        return [
            'token' => 'required|string|min:1|max:100'
        ];
    }
}
