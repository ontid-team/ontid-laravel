<?php

namespace App\Services\Auth\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class AuthLogicException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => __('exception.' . $this->getMessage()),
            'code' => $this->getMessage()
        ], 422);
    }
}
