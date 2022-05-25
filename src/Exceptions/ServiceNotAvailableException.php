<?php

namespace Layoute\LaravelWeather\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class ServiceNotAvailableException extends Exception
{
    public function __construct($message = "Service is not available for now", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'code' => $this->code,
            'message' => $this->message,
        ]);
    }
}
