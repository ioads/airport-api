<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFlightRequest;
use App\Http\Requests\UpdateFlightRequest;
use App\Models\Flight;
use App\Repositories\FlightRepositoryInterface;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    protected $flightRepository;

    public function __construct(FlightRepositoryInterface $flightRepository)
    {
        $this->flightRepository = $flightRepository;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flights = $this->flightRepository->all();

        return response()->json($flights);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFlightRequest $request)
    {
        $data = $request->validated();
        
        $flight = $this->flightRepository->create($data);

        return response()->json($flight);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Flight $flight, UpdateFlightRequest $request)
    {
        $data = $request->validated();

        $flight = $this->flightRepository->update($flight, $data);

        return response()->json($flight);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Flight $flight)
    {
        return $this->flightRepository->delete($flight);
    }
}
