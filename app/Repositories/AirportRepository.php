<?php

namespace App\Repositories;

use App\Models\Airport;
use Illuminate\Database\Eloquent\Collection;

class AirportRepository implements AirportRepositoryInterface
{
    protected Airport $model;

    public function __construct(Airport $airport)
    {
        $this->model = $airport;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }
}
