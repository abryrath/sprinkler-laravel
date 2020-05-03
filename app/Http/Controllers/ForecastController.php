<?php

namespace App\Http\Controllers;

use App\Repositories\ForecastRepositoryInterface;
use App\Services\OpenWeatherAPI;

class ForecastController extends Controller
{
    //
    public function index(OpenWeatherAPI $api, ForecastRepositoryInterface $forecasts)
    {
        return $api->getForecast($forecasts);
        // return ['hello' => 'world'];
    }
}
