<?php

namespace Layoute\LaravelWeather;

use Illuminate\Support\ServiceProvider;

class WeatherServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function boot()
    {
        $this->publishes([
            \dirname(__DIR__) . ('/config/weather.php') => config_path('weather.php')
        ], 'laravel-weather-config');
    }

    public function register()
    {
        $this->app->singleton(LaravelWeather::class, function () {
            return new LaravelWeather();
        });
    }
}
