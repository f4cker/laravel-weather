<?php

namespace Layoute\LaravelWeather;

use Illuminate\Support\Facades\Facade;

class LaravelWeatherFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return LaravelWeather::class;
    }
}
