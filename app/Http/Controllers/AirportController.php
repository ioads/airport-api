<?php

namespace App\Http\Controllers;

use App\Repositories\AirportRepositoryInterface;

class AirportController extends Controller
{
    private $airportRepository;

    public function __construct(AirportRepositoryInterface $airportRepository)
    {
        $this->airportRepository = $airportRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/airports",
     *      operationId="getAirportsList",
     *      tags={"Airports"},
     *      summary="Get list of airports",
     *      description="Returns list of airports",
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad request")
     * )
     */
    public function index()
    {
        $airports = $this->airportRepository->all();

        return response()->json($airports);
    }
}
