<?php

namespace Layoute\LaravelWeather;

use Layoute\LaravelWeather\Exceptions\CityNotFoundException;
use Layoute\LaravelWeather\Exceptions\ServiceNotAvailableException;
use Layoute\LaravelWeather\Services\CaiyunWeatherService;
use Layoute\LaravelWeather\Services\QWeatherService;

class Weather
{
    protected $config;

    private $services = [
        'qweather' => QWeatherService::class,
        'caiyun' => CaiyunWeatherService::class,
    ];

    public function config(array $conf): Weather
    {
        $this->config = $conf;
        return $this;
    }

    /**
     * @throws CityNotFoundException
     * @throws ServiceNotAvailableException
     */
    public function getRealTimeWeather(array $city, string $service = 'qweather'): string
    {
        if (empty($this->config)) {
            throw new ServiceNotAvailableException("Invalid service configuration");
        }
        if (empty($city)) {
            throw new CityNotFoundException();
        }
        if (!array_key_exists($service, $this->services)) {
            throw new ServiceNotAvailableException("Service has not been supported for now");
        }
        $weather = new $this->services[$service];
        return $weather->config($this->config[$service])->getRealTimeWeather($city);
    }
}
