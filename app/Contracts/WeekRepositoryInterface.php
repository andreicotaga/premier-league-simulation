<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

/**
 * Interface WeekRepositoryInterface
 * @package App\Contracts
 */
interface WeekRepositoryInterface
{
    public function get(): Collection;
}
