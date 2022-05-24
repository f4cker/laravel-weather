<?php

namespace Layoute\LaravelWeather;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Layoute\LaravelWeather\Exception\APIKeyNotFoundException;

class LaravelWeather
{
    protected $config;

    public function config(array $conf): LaravelWeather
    {
        $this->config = $conf;
        return $this;
    }

    /**
     * @throws APIKeyNotFoundException
     */
    private function getEnv(): array
    {
        if (isset($this->config)) {
            if ($this->config['dev_mode']) {
                return $this->config['dev'];
            } else {
                return $this->config['prod'];
            }
        } else {
            throw new APIKeyNotFoundException();
        }
    }

    /**
     * @throws APIKeyNotFoundException
     */
    private function getAppKey(): string
    {
        if (isset($this->config)) {
            return $this->config['qweather']['key'];
        } else {
            throw new APIKeyNotFoundException();
        }
    }

    /**
     * Get real-time weather info for specified city
     * @param string $locationId location id for city
     * @param string $lang language setting for response
     * @return string
     */
    public function queryWeatherForCity(string $locationId, string $lang = "zh"): string
    {

        return "";
    }

    /**
     * @throws APIKeyNotFoundException
     */
    public function getLocationIdByName(string $city_name, string $adm = null, string $range = "world", string $lang = "zh"): string
    {
        $env = $this->getEnv();
        if (isset($this->config)) {
            $endpoint = $env['geo_base_url'] . '/city/lookup?location=' . $city_name . '&key=' . $this->getAppKey() . '&adm=' . $adm . '&range=' . $range . '&lang=' . $lang;
            return "";
        } else {
            throw new APIKeyNotFoundException();
        }
    }

    /**
     * @throws APIKeyNotFoundException
     * @throws GuzzleException
     */
    public function getLocationIdByCoordinate(float $lat, float $lng, string $adm = null, string $range = "world", string $lang = "zh"): string
    {
        $env = $this->getEnv();
        if (isset($this->config)) {
            $endpoint = $env['geo_base_url'] . '/city/lookup?location=' . $lat . '.' . $lng . '&key=' . $this->getAppKey() . '&adm=' . $adm . '&range=' . $range . '&lang=' . $lang;
            $http = new Client;
            $response = $http->get($endpoint);
            Log::info($response->getBody());
            return "";
        } else {
            throw new APIKeyNotFoundException();
        }
    }
}
