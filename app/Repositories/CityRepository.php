<?php

namespace App\Repositories;

use App\Models\City;
use Illuminate\Database\Eloquent\Collection;

class CityRepository implements CityRepositoryInterface
{
    protected City $model;

    public function __construct(City $city)
    {
        $this->model = $city;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }
}
