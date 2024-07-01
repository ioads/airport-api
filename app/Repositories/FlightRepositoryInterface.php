<?php

namespace App\Repositories;

use App\Models\Flight;

interface FlightRepositoryInterface
{
    public function all();

    public function find($id);

    public function create(array $data);

    public function update(Flight $flight, array $data);

    public function updateOrCreate(array $find, array $data);

    public function delete(Flight $flight);
}
