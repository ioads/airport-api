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
        return $this->model->with('classes')->get();
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

            if($flight->origin->iata_code == $flight->destination->iata_code) {
                throw new Exception('Os aeroportos não podem estar situados na mesma cidade.');
            }

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
            throw new Exception($e->getMessage());
            throw new Exception('Erro ao criar voo');
        }
    }

    public function update(Flight $flight, array $data)
    {
        $flight->update($data);
        return $flight;
    }

    public function updateOrCreate(array $find, array $data)
    {
        return $this->model->updateOrCreate($find, $data);
    }

    public function delete(Flight $flight): int
    {
        return $flight->delete();
    }

    public function passengers(string $flightId)
    {
        return $this->model->find($flightId)->tickets->whereNotNull('buyer_cpf');
    }
}
