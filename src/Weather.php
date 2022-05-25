<?php

namespace Layoute\LaravelWeather;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Layoute\LaravelWeather\Exceptions\APIKeyNotFoundException;
use Layoute\LaravelWeather\Exceptions\CityNotFoundException;

class Weather
{
    protected $config;
    protected $http;
    protected $env;

    /**
     * @throws APIKeyNotFoundException
     */
    public function config(array $conf): Weather
    {
        $this->config = $conf;
        $this->http = new Client;
        $this->env = $this->getEnv();
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
     * @param string $city_name
     * @param string $lang language setting for response
     * @return string
     * @throws APIKeyNotFoundException
     * @throws GuzzleException
     * @throws CityNotFoundException
     */
    public function getWeatherForCityByName(string $city_name, string $lang = "zh"): string
    {
        $city = $this->getLocationIdByName($city_name);
        if (empty($city)) {
            throw new CityNotFoundException();
        } else {
            $locations = json_decode($city, true)['location'];
            if (empty($locations)) {
                throw new CityNotFoundException();
            } else {
                $endpoint = $this->env['api_base_url'] . 'weather/now';
                $resp = $this->http->get($endpoint, [
                    'query' => [
                        'location' => $locations[0]['id'],
                        'key' => $this->getAppKey()
                    ]
                ]);
                return $resp->getBody();
            }
        }
    }

    /**
     * @throws APIKeyNotFoundException
     * @throws GuzzleException
     */
    public function getLocationIdByName(string $city_name, string $adm = null, string $range = "world", string $lang = "zh"): string
    {
        if (isset($this->config)) {
            $endpoint = $this->env['geo_base_url'] . '/city/lookup';
            $response = $this->http->get($endpoint, [
                'query' => [
                    'location' => $city_name,
                    'key' => $this->getAppKey(),
                    'adm' => $adm,
                    'range' => $range,
                    'lang' => $lang,
                ]
            ]);
            return $response->getBody();
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
        if (isset($this->config)) {
            $endpoint = $this->env['geo_base_url'] . '/city/lookup';
            $response = $this->http->get($endpoint, [
                'query' => [
                    'location' => $lat . ',' . $lng,
                    'key' => $this->getAppKey(),
                    'adm' => $adm,
                    'range' => $range,
                    'lang' => $lang,
                ]
            ]);
            return $response->getBody();
        } else {
            throw new APIKeyNotFoundException();
        }
    }
}
