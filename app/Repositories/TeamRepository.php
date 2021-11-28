<?php

namespace App\Repositories;

use App\Contracts\TeamRepositoryInterface;
use App\Models\Team;
use Illuminate\Support\Collection;

/**
 * Class TeamRepository
 * @package App\Repositories
 */
class TeamRepository implements TeamRepositoryInterface
{
    /**
     * @var Team
     */
    private $resource;

    /**
     * TeamRepository constructor.
     * @param Team $resource
     */
    public function __construct(Team $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->resource->all();
    }

    /**
     * @return array
     */
    public function getTeamIds(): array
    {
        return $this->resource->pluck('id')->toArray();
    }

    /**
     * @return Collection
     */
    public function getTeamsWithStandings(): Collection
    {
        return $this->resource->with(['standing' => function ($query) {
            $query->orderBy('points', 'DESC');
            $query->orderBy('goal_drawn', 'DESC');
            $query->orderBy('won', 'DESC');
        }])->get();
    }
}
