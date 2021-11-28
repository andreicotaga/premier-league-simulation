<?php

namespace App\Providers;

use App\Contracts\InitializationServiceInterface;
use App\Services\InitializationService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * @var string[]
     */
    public $singletons = [
        InitializationServiceInterface::class => InitializationService::class,
    ];
}
