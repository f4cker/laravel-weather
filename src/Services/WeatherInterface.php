<?php

namespace Layoute\LaravelWeather\Services;

interface WeatherInterface
{

    public function config(array $conf);

    public function getRealTimeWeather(array $city): string;
}

