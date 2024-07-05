<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFlightRequest;
use App\Http\Requests\UpdateFlightRequest;
use App\Http\Resources\FlightResource;
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
     * @OA\Get(
     *      path="/api/flights",
     *      operationId="getFlightsList",
     *      tags={"Flights"},
     *      summary="Get list of flights",
     *      description="Returns list of flights",
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad request")
     * )
     */
    public function index()
    {
        $flights = $this->flightRepository->all();

        return response()->json($flights);
    }

    /**
     * @OA\Post(
     *      path="/api/flights",
     *      operationId="storeFlight",
     *      tags={"Flights"},
     *      summary="Store flight",
     *      description="Store a flight",
    *      @OA\RequestBody(
    *          required=true,
    *          description="Create Flight",
    *          @OA\JsonContent(
    *              @OA\Property(property="origin_id", type="string", example="1"),
    *              @OA\Property(property="destination_id", type="string", format="email", example="2"),
    *              @OA\Property(property="code", type="string", example="1234"),
    *              @OA\Property(property="departure", type="date", example="2024-08-25 12:00:00"),
    *              @OA\Property(property="classes", type="array", 
    *                  @OA\Items(
    *                      @OA\Property(property="class_id", type="integer", example=1),
    *                      @OA\Property(property="seats", type="integer", example="30"),
    *                      @OA\Property(property="unit_price", type="float", example="1500.50"),
    *                  ),
    *              ),
    *          )
    *      ),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad request")
     * )
     */
    public function store(StoreFlightRequest $request)
    {
        $data = $request->validated();
        
        $flight = $this->flightRepository->create($data);

        return new FlightResource($flight);
    }

    /**
     * @OA\Put(
     *      path="/api/flights/{flight}",
     *      operationId="updateFlight",
     *      tags={"Flights"},
     *      summary="Update flight",
     *      description="Update a flight",
    *      @OA\RequestBody(
    *          required=true,
    *          description="Update a Flight",
    *          @OA\JsonContent(
    *              @OA\Property(property="origin_id", type="string", example="1"),
    *              @OA\Property(property="destination_id", type="string", format="email", example="2"),
    *              @OA\Property(property="code", type="string", example="1234"),
    *              @OA\Property(property="departure", type="date", example="2024-08-25 12:00:00"),
    *          )
    *      ),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad request")
     * )
     */
    public function update(Flight $flight, UpdateFlightRequest $request)
    {
        $data = $request->validated();

        $flight = $this->flightRepository->update($flight, $data);

        return new FlightResource($flight);
    }

    /**
     * @OA\Delete(
     *      path="/api/flights/{flight}",
     *      operationId="cancelFlight",
     *      tags={"Flights"},
     *      summary="Cancel flight",
     *      description="Cancel a flight",
    *      @OA\RequestBody(
    *          required=true,
    *          description="Cancel a Flight",
    *      ),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad request")
     * )
     */
    public function destroy(Flight $flight)
    {
        return $this->flightRepository->delete($flight);
    }

    /**
     * @OA\Get(
     *      path="/api/flights/passengers/{flight}",
     *      operationId="passengersFlight",
     *      tags={"Flights"},
     *      summary="Get passengers by flight",
     *      description="Get passengers by flight",
    *      @OA\RequestBody(
    *          required=true,
    *          description="Get passengers by Flight",
    *      ),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad request")
     * )
     */
    public function passengers(string $flightId)
    {
        $passengers = $this->flightRepository->passengers($flightId);

        return response()->json($passengers);
    }
}
