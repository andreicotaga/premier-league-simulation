<?php

namespace App\Http\Controllers;

use App\Contracts\InitializationServiceInterface;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

/**
 * Class IndexController
 * @package App\Http\Controllers
 */
class IndexController
{
    /**
     * @var InitializationServiceInterface
     */
    private $initializationService;

    /**
     * IndexController constructor.
     * @param InitializationServiceInterface $initializationService
     */
    public function __construct(InitializationServiceInterface $initializationService)
    {
        $this->initializationService = $initializationService;
    }

    /**
     * @return Application|Factory|View
     */
    public function init()
    {
        $this->initializationService->create();

        return view('index');
    }

    /**
     * @return JsonResponse
     */
    public function standings(): JsonResponse
    {
        return response()->json([
            'data' => $this->initializationService->getAllTeamsWithStandings(),
            'status' => true
        ]);
    }

    /**
     * Reset all data
     * @throws Exception
     */
    public function reset(): JsonResponse
    {
        try {
            $this->initializationService->reset();
        } catch (Exception $exception) {
            throw new Exception(['exception' => $exception->getMessage()]);
        }

        return response()->json(['status' => true]);
    }
}
