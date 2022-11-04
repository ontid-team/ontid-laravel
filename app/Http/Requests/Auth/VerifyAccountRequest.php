<?php

namespace App\Http\Requests\Auth;

use App\Classes\Abstracts\BaseRequest;
use App\Classes\Validation\Fields\TokenField;
use App\Services\Auth\Interfaces\IVerifyRequest;
use OpenApi\Attributes as OA;

/**
 * @property mixed $token
 */
#[OA\Schema(required: ['token'])]
class VerifyAccountRequest extends BaseRequest implements IVerifyRequest
{
    #[OA\Property(property: 'token', type: 'string')]

    protected function validators(): array
    {
        return [
            TokenField::class
        ];
    }

    public function getToken()
    {
        return $this->token;
    }
}
