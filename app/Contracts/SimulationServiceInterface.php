<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface SimulationServiceInterface
 * @package App\Contracts
 */
interface SimulationServiceInterface
{
    public function play(int $weekId): Collection;

    public function playAll(): void;
}
