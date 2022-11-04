<?php

namespace App\Http\Requests\Auth;

use App\Classes\Abstracts\BaseRequest;
use App\Classes\Validation\Fields\EmailField;
use App\Services\Auth\Interfaces\IForgotRequest;
use OpenApi\Attributes as OA;

/**
 * @property mixed $email
 */
#[OA\Schema(required: ['email'])]
class ForgotPasswordRequest extends BaseRequest implements IForgotRequest
{
    #[OA\Property(property: 'email', type: 'string')]
    protected function validators(): array
    {
        return [
            EmailField::options(required:  true)
        ];
    }

    public function getEmail()
    {
        return $this->email;
    }
}
