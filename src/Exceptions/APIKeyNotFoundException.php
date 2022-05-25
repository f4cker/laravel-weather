<?php

namespace Layoute\LaravelWeather\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class APIKeyNotFoundException extends Exception
{
    public function __construct($message = "API Key Not Found", $code = 500, Throwable $previous = null)
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
