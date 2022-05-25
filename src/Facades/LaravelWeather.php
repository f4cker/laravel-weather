<?php

namespace Layoute\LaravelWeather\Facades;

use Illuminate\Support\Facades\Facade;
use Layoute\LaravelWeather\Weather;

/**
 * @method static Weather config(array $conf)
 * @method static Weather getWeatherByName(string $city_name, string $lang = "zh")
 * @method static Weather getWeatherByCoordinate(float $lat, float $lng, string $lang = "zh")
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
