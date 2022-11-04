<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class InvalidRequestHeadersException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => __('exception.invalid_headers')
        ], 406);
    }
}
