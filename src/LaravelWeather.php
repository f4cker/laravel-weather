<?php

namespace Layoute\LaravelWeather;

class LaravelWeather
{
    private $base_url = "https://devapi.qweather.com/v7/";
    private $geo_base_url = "https://geoapi.qweather.com/v2/";
    protected $config;

    public function config(array $conf)
    {
        $this->config = $conf;
    }

    /**
     * Get real-time weather info for specified city
     * @param string $location location id for city
     * @param string $lang language setting for response
     * @return string
     */
    public function query_weather_for_city(string $location, string $lang = "zh"): string
    {

        return "";
    }
}
