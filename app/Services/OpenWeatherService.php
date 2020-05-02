<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\ForecastRepositoryInterface;
use GuzzleHttp\Psr7\Response;

class OpenWeatherService implements OpenWeatherAPI
{
    /** @var \GuzzleHttp\Client|null */
    private $client;

    private const FORECAST_URI = '/data/2.5/forecast';

    public function getForecast(ForecastRepositoryInterface $forecasts)
    {
        /** @var Collection */
        $today = $forecasts->today();
        if (!$today->isEmpty()) {
            return $today;
        }

        $resp = $this->getClient()
            ->get(self::FORECAST_URI);
        $models = $this->parseResponse($resp);
        return $models;
    }

    public function getClient(): Client
    {
        if (!$this->client) {
            $this->client = new Client([
                'base_uri' => config('app.open_weather.base_url'),
                'query' => [
                    'zip' => '28208',
                    'appid' => config('app.open_weather.api_key'),
                ],
            ]);
        }
        return $this->client;
    }

    private function parseResponse(Response $resp)
    {
        $body = $resp->getBody();
        $json_contents = $body->getContents();
        $contents = json_decode($json_contents, true);


        return [];
    }
}
