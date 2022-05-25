<?php

namespace Layoute\LaravelWeather\Facades;

use Illuminate\Support\Facades\Facade;
use Layoute\LaravelWeather\Weather;

/**
 * @method static Weather config(array $conf)
 * @method static string getRealTimeWeather(array $city)
 *
 * @see Weather
 */
class LaravelWeather extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'weather';
    }
}
