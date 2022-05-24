<?php

namespace Layoute\LaravelWeather\Exception;

use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class CityNotFoundException extends Exception
{
    public function __construct($message = "City Not Found", $code = 502, Throwable $previous = null)
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
