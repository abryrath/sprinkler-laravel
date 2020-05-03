<?php

namespace App\Repositories;

use App\Forecast;
use Carbon\Carbon;

class ForecastRepository implements ForecastRepositoryInterface
{
    /**
     * @param int $id
     * @return Forecast|null
     */
    public function get($id)
    {
        return Forecast::find($id);
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return Forecast::all();
    }

    public function delete($id)
    {
        return Forecast::destroy($id);
    }

    public function update($id, $data)
    {
        return Forecast::find($id)->update($data);
    }

    /**
     * @inheritdoc
     */
    public function today()
    {
        $today = (new \DateTime())->format('Y-m-d');
        return Forecast::query()
            ->where('date', '=', $today)
            ->get();
    }

    /**
     * Refresh the data if it was last updated more than 12
     * hours ago
     */
    public function shouldRefresh(): bool
    {
        $today = Carbon::now("UTC");
        $latest = Forecast::query()
            ->latest()
            ->first();
        var_dump($latest);
        $latestDate = new Carbon($latest->date_created, "UTC");
        echo "today: " . $today->format('Y-m-d h:m:s');
        echo " latest: " . $latestDate->format('Y-m-d h:m:s');
        die;
        $cutoff = $today->subHours(12);
        return $latestDate->isAfter($cutoff);
    }

    /**
     * @inheritdoc
     */
    public function fromApi($data)
    {
        $main = $data['main'];
        $weather = $data['weather'][0];
        $wind = $data['wind'];
        $dt = (int) $data['dt'];

        $attributes = [
            'hour' => Forecast::timestampToHour($dt),
            'date' => Forecast::timestampToDate($dt),
            'humidity' => $main['humidity'],
            'temp' => Forecast::kelvinToF($main['temp']),
            'feels_like' => Forecast::kelvinToF($main['feels_like']),
            'description' => $weather['description'],
            'summary' => $weather['main'],
            'wind_speed' => $wind['speed'],
            'wind_dir' => $wind['deg'],
            'pressure' => $main['pressure'],
        ];
        $forecast = new Forecast($attributes);
        $forecast->save();
        return $forecast;
    }
}
