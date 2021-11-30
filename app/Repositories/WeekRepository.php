<?php

namespace App\Repositories;

use App\Contracts\WeekRepositoryInterface;
use App\Models\Week;
use Illuminate\Support\Collection;

/**
 * Class WeekRepository
 * @package App\Repositories
 */
class WeekRepository implements WeekRepositoryInterface
{
    /**
     * @var Week
     */
    private $resource;

    /**
     * WeekRepository constructor.
     * @param Week $resource
     */
    public function __construct(Week $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @return Collection
     */
    public function get(): Collection
    {
        return $this->resource->get();
    }
}
