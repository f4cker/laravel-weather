<?php

namespace Layoute\LaravelWeather;

class LaravelWeather
{
    protected $config;

    public function config(array $conf): LaravelWeather
    {
        $this->config = $conf;
        return $this;
    }

    /**
     * Get real-time weather info for specified city
     * @param string $location location id for city
     * @param string $lang language setting for response
     * @return string
     */
    public function queryWeatherForCity(string $location, string $lang = "zh"): string
    {

        return "";
    }
}
