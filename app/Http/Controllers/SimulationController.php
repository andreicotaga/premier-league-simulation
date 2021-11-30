<?php

namespace App\Http\Controllers;

use App\Contracts\SimulationServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Class SimulationController
 * @package App\Http\Controllers
 */
class SimulationController
{
    /**
     * @var SimulationServiceInterface
     */
    private $simulationService;

    /**
     * SimulationController constructor.
     * @param SimulationServiceInterface $simulationService
     */
    public function __construct(SimulationServiceInterface $simulationService)
    {
        $this->simulationService = $simulationService;
    }

    /**
     * Play only one week
     *
     * @param int $weekId
     * @return JsonResponse
     */
    public function play(int $weekId): JsonResponse
    {
        $data = $this->simulationService->play($weekId);

        return response()->json(['status' => true, 'matches' => $data]);
    }

    /**
     * Play all weeks
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function playAll(): JsonResponse
    {
        $this->simulationService->playAll();

        return response()->json(['status' => true]);
    }
}
