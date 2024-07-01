<?php

namespace App\Http\Controllers;

use App\Repositories\CityRepositoryInterface;
use Illuminate\Http\Request;

class CityController extends Controller
{
    private $cityRepository;

    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/cities",
     *      operationId="getCitiesList",
     *      tags={"Cities"},
     *      summary="Get list of cities",
     *      description="Returns list of cities",
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad request")
     * )
     */
    public function index()
    {
        $cities = $this->cityRepository->all();

        return response()->json($cities);
    }
}
