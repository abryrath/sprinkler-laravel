<?php

namespace App\Http\Controllers;

use App\Repositories\ForecastRepositoryInterface;
use App\Services\OpenWeatherAPI;
use Illuminate\Http\Request;

class ForecastController extends Controller
{
    //
    public function index(OpenWeatherAPI $api, ForecastRepositoryInterface $forecasts)
    {
        return $api->getForecast($forecasts);
        // return ['hello' => 'world'];
    }
}
