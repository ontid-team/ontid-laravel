<?php

namespace App\Http\Requests\Auth;

use App\Classes\Abstracts\BaseRequest;
use App\Services\Auth\Interfaces\ISocialAuthenticateRequest;
use OpenApi\Attributes as OA;

/**
 * @property mixed $token
 */
#[OA\Schema(required: ['token', 'type'])]
class SocialRequest extends BaseRequest implements ISocialAuthenticateRequest
{
    #[OA\Property(property: 'token', type: 'string')]
    #[OA\Property(property: 'type', description: 'user type: salon, customer', type: 'enum')]
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'type' => 'required|in:salon,customer',
            'token' => 'required|string'
        ];
    }

    public function getToken()
    {
        return $this->token;
    }
}
