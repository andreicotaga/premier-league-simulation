<?php

namespace App\Providers;

use App\Contracts\InitializationServiceInterface;
use App\Contracts\PredictionServiceInterface;
use App\Contracts\SimulationServiceInterface;
use App\Services\InitializationService;
use App\Services\PredictionService;
use App\Services\SimulationService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * @var string[]
     */
    public $singletons = [
        InitializationServiceInterface::class => InitializationService::class,
        SimulationServiceInterface::class => SimulationService::class,
        PredictionServiceInterface::class => PredictionService::class,
    ];
}
