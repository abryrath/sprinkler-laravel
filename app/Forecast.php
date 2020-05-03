<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    public const KELVIN_OFFSET = 272.0;
    public const FAHRENHEIT_OFFSET = 32.0;

    protected $table = 'forecasts';
    protected $fillable = [
        'hour',
        'date',
        'humidity',
        'temp',
        'feels_like',
        'description',
        'summary',
        'wind_speed',
        'wind_dir',
        'pressure',
    ];

    public static function timestampToHour(int $timestamp): int
    {
        $dateTime = Carbon::createFromTimestamp($timestamp, 'America/New_York');
        return (int) $dateTime->format('H');
    }

    public static function timestampToDate(int $timestamp): string
    {
        $dateTime = Carbon::createFromTimestamp($timestamp, 'America/New_York');
        return $dateTime->format('Y-m-d');
    }

    /**
     * @return int|float
     */
    public static function kelvinToF(float $k, bool $round = true)
    {
        $f = (9.0 / 5.0) * ($k - self::KELVIN_OFFSET) + self::FAHRENHEIT_OFFSET;
        return $round ? ceil($f) : $f;
    }
}
