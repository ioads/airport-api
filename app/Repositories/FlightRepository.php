<?php

namespace App\Repositories;

use App\Models\ClassFlight;
use App\Models\Flight;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class FlightRepository implements FlightRepositoryInterface
{
    protected Flight $model;
    protected ClassFlight $classFlight;

    public function __construct(Flight $flight, ClassFlight $classFlight)
    {
        $this->model = $flight;
        $this->classFlight = $classFlight;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        try {
            DB::beginTransaction();
            
            $flight = $this->model->create($data);

            $seatsAvailable = 0;

            foreach($data['classes'] as $class) {
                $seatsAvailable += $class['seats'];
                $class['flight_id'] = $flight->id;
                $this->classFlight->create($class);
            }

            $flight->update(['seats_available' => $seatsAvailable]);
        
            DB::commit();
            
            return $flight;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Erro ao criar voo');
        }
    }

    public function update($id, array $data)
    {
        $user = $this->model->find($id);
        $user->update($data);
        return $user;
    }

    public function updateOrCreate(array $find, array $data)
    {
        return $this->model->updateOrCreate($find, $data);
    }

    public function delete(Flight $flight): int
    {
        return $flight->delete();
    }
}
