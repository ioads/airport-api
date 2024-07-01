<?php

namespace App\Http\Controllers;

use App\Repositories\ClassRepositoryInterface;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    private $classRepository;

    public function __construct(ClassRepositoryInterface $classRepository)
    {
        $this->classRepository = $classRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/classes",
     *      operationId="getClassesList",
     *      tags={"Classes"},
     *      summary="Get list of classes",
     *      description="Returns list of classes",
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad request")
     * )
     */
    public function index()
    {
        $classes = $this->classRepository->all();

        return response()->json($classes);
    }
}
