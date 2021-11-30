<?php

namespace App\Http\Controllers;

use App\Contracts\PredictionServiceInterface;
use Illuminate\Http\JsonResponse;

class PredictionController
{
    /**
     * @var PredictionServiceInterface
     */
    private $predictionService;

    /**
     * PredictionController constructor.
     * @param PredictionServiceInterface $predictionService
     */
    public function __construct(PredictionServiceInterface $predictionService)
    {
        $this->predictionService = $predictionService;
    }

    /**
     * Get prediction
     *
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        return response()->json(['status' => true, 'data' => $this->predictionService->getPrediction()]);
    }
}
