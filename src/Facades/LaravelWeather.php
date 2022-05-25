<?php

namespace Layoute\LaravelWeather\Facades;

use Illuminate\Support\Facades\Facade;
use Layoute\LaravelWeather\Weather;

/**
 * @method static Weather config(array $conf)
 * @method static Weather getWeatherForCityByName(string $city_name, string $lang = "zh")
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
