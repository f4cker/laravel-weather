<?php

namespace Layoute\LaravelWeather\Facades;

use Illuminate\Support\Facades\Facade;
use Layoute\LaravelWeather\Weather;

/**
 * @method static Weather config(array $conf)
 * @method static string getWeatherByName(string $city_name, string $lang = "zh")
 * @method static string getWeatherByCoordinate(float $lat, float $lng, string $lang = "zh")
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
