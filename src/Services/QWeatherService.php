<?php

namespace Layoute\LaravelWeather\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Layoute\LaravelWeather\Exceptions\APIKeyNotFoundException;
use Layoute\LaravelWeather\Exceptions\CityNotFoundException;
use Layoute\LaravelWeather\Exceptions\ServiceNotAvailableException;

class QWeatherService implements WeatherInterface
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
     * @throws GuzzleException
     * @throws CityNotFoundException|APIKeyNotFoundException
     */
    public function getRealTimeWeather(array $city): string
    {
        $city_name = $city['city_name'];
        $lat = $city['lat'];
        $lng = $city['lng'];
        if (!empty($city_name)) {
            return $this->getWeatherByName($city_name);
        } else {
            if (!empty($lat) && !empty($lng)) {
                return $this->getWeatherByCoordinate($lat, $lng);
            } else {
                throw new CityNotFoundException();
            }
        }
    }

    /**
     * @throws APIKeyNotFoundException|ServiceNotAvailableException
     */
    private function getEnv(): array
    {
        if (isset($this->config)) {
            if (isset($this->config['dev_mode'])) {
                if ($this->config['dev_mode']) {
                    return $this->config['dev'];
                } else {
                    return $this->config['prod'];
                }
            }
            throw new APIKeyNotFoundException();
        }
        throw new ServiceNotAvailableException("Service is not available for now $this->env",);
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
     * Get real-time weather info for specified city
     * @param string $city_name
     * @param string $lang language setting for response
     * @return string
     * @throws APIKeyNotFoundException
     * @throws GuzzleException
     * @throws CityNotFoundException
     */
    public function getWeatherByName(string $city_name, string $lang = "zh"): string
    {
        $city = $this->getLocationIdByName($city_name);
        return $this->getWeather($city);
    }

    /**
     * Get real-time weather info for specified city
     * @param float $lat
     * @param float $lng
     * @param string $lang language setting for response
     * @return string
     * @throws APIKeyNotFoundException
     * @throws GuzzleException
     * @throws CityNotFoundException
     */
    public function getWeatherByCoordinate(float $lat, float $lng, string $lang = "zh"): string
    {
        $city = $this->getLocationIdByCoordinate($lat, $lng);
        return $this->getWeather($city);
    }

    /**
     * @throws APIKeyNotFoundException
     * @throws CityNotFoundException
     */
    private function getWeather(string $city): string
    {
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
