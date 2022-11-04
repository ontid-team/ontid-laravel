<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class CreateModelException extends Exception
{
    public function render(): JsonResponse
    {
        dd($this);
        return response()->json([
            'exception' => __('exception.create_model_exception')
        ], 500);
    }
}
