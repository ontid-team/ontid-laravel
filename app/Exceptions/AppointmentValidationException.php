<?php

namespace App\Exceptions;

use App\Http\Resources\AppointmentResource;
use Illuminate\Http\JsonResponse;
use Throwable;

class AppointmentValidationException extends ValidationException
{
    private $appointments = null;

    public function __construct($appointments, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $this->appointments = $appointments;
        parent::__construct($message, $code, $previous);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            //'message' => $this->message,
            'appointments' => AppointmentResource::collection($this->appointments)
        ], 422);
    }
}
