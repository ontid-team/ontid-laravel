<?php

namespace App\Services\Auth\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class InvalidPasswordException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => __('auth.invalid_user_or_password')
        ], 422);
    }
}
