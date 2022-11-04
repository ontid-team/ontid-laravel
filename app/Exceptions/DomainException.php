<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class DomainException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => __('exception.' . $this->getMessage())
        ], 422);
    }
}
