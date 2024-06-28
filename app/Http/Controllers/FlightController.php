<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFlightRequest;
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
