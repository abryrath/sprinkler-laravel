<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class OpenWeatherServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Services\OpenWeatherAPI',
            'App\Services\OpenWeatherService'
        );
        $this->app->bind(
            'App\Repositories\ForecastRepositoryInterface',
            'App\Repositories\ForecastRepository'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
