<?php

namespace App\Repositories;

use App\Forecast;

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
     * @inheritdoc
     */
    public function fromApi($data)
    {
        return [];
    }
}
