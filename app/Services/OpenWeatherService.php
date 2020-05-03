<?php

namespace App\Services;

use App\Repositories\ForecastRepositoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Collection;

class OpenWeatherService implements OpenWeatherAPI
{
    /** @var \GuzzleHttp\Client|null */
    private $client;

    private const FORECAST_URI = '/data/2.5/forecast';

    public function getForecast(ForecastRepositoryInterface $forecasts)
    {
        $shouldRefresh = $forecasts->shouldRefresh();
        var_dump($shouldRefresh);die;
        /** @var Collection */
        $today = $forecasts->today();
        if (!$today->isEmpty()) {
            return $today;
        }

        $resp = $this->getClient()
            ->get(self::FORECAST_URI);
        $models = $this->parseResponse($resp, $forecasts);
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

    private function parseResponse(Response $resp, ForecastRepositoryInterface $forecasts)
    {
        $body = $resp->getBody();
        $json_contents = $body->getContents();
        $contents = json_decode($json_contents, true);
        $list = $contents['list'];

        // $today = (new \DateTime())->format('Y-m-d');

        $parsed = [];
        foreach ($list as $f) {
            $parsed[] = $forecasts->fromApi($f);
        }
        return $collect($parsed);
    }
}
