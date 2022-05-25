<?php

namespace Layoute\LaravelWeather\Services;

use GuzzleHttp\Client;
use Layoute\LaravelWeather\Exceptions\APIKeyNotFoundException;
use Layoute\LaravelWeather\Exceptions\CityNotFoundException;
use Layoute\LaravelWeather\Exceptions\ServiceNotAvailableException;

class CaiyunWeatherService implements WeatherInterface
{
    protected $config;
    protected $http;
    protected $env;

    /**
     * @throws APIKeyNotFoundException|ServiceNotAvailableException
     */
    public function config(array $conf): WeatherInterface
    {
        if (empty($conf)) {
            throw new ServiceNotAvailableException();
        }
        if (empty($conf['app_key'])) {
            throw new APIKeyNotFoundException();
        }
        $this->config = $conf;
        $this->http = new Client;
        $this->env = $this->getEnv();
        return $this;
    }

    /**
     * '@throws CityNotFoundException
     * @throws APIKeyNotFoundException
     */
    public function getRealTimeWeather(array $city): string
    {
        $lat = $city['lat'];
        $lng = $city['lng'];
        return $this->getWeather($lat, $lng);
    }

    /**
     * @throws APIKeyNotFoundException
     * @throws ServiceNotAvailableException
     */
    private function getEnv(): array
    {
        if (isset($this->config)) {
            if (isset($this->config['prod'])) {
                return $this->config['prod'];
            }
            throw new APIKeyNotFoundException();
        }
        throw new ServiceNotAvailableException();
    }

    /**
     * @throws APIKeyNotFoundException
     */
    private function getAppKey(): string
    {
        if (isset($this->config)) {
            return $this->config['app_key'];
        } else {
            throw new APIKeyNotFoundException();
        }
    }

    /**
     * @throws APIKeyNotFoundException
     * @throws CityNotFoundException
     */
    private function getWeather(float $lat, float $lng): string
    {
        if (empty($lat) || empty($lng)) {
            throw new CityNotFoundException();
        } else {
            $endpoint = $this->env['api_base_url'] . '/' . $this->getAppKey() . '/' . $lat . ',' . $lng . '/realtime';
            $resp = $this->http->get($endpoint);
            return $resp->getBody();
        }
    }
}
