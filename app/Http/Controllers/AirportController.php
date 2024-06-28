<?php

namespace App\Http\Controllers;

use App\Repositories\AirportRepositoryInterface;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    private $airportRepository;

    public function __construct(AirportRepositoryInterface $airportRepository)
    {
        $this->airportRepository = $airportRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $airports = $this->airportRepository->all();

        return response()->json($airports);
    }
}
