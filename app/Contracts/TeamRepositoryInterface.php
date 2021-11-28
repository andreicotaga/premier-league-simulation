<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

/**
 * Interface TeamRepositoryInterface
 * @package App\Contracts
 */
interface TeamRepositoryInterface
{
    public function getTeamsWithStandings(): Collection;
}
