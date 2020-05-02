<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface ForecastRepositoryInterface
{
    public function get($id);
    public function all();
    public function delete($id);
    public function update($id, $data);

    /**
     * @return Collection
     */
    public function today();

    /**
     * @param array $data
     * @return Collection
     */
    public function fromApi($data);
}
