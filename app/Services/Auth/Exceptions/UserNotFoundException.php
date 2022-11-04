<?php

namespace App\Services\Auth\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class UserNotFoundException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => __('auth.invalid_user_or_password')
        ], 422);
    }
}
