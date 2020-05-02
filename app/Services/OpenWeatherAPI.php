<?php

namespace App\Services;

use App\Repositories\ForecastRepositoryInterface;

interface OpenWeatherAPI {
    public function getForecast(ForecastRepositoryInterface $forecasts);
}
