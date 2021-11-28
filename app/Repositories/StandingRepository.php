<?php

namespace App\Repositories;

use App\Contracts\StandingRepositoryInterface;
use App\Models\Standing;
use App\Models\Team;

class StandingRepository implements StandingRepositoryInterface
{
    /**
     * @var Standing
     */
    private $resource;

    /**
     * @var Team
     */
    private $team;

    /**
     * StandingRepository constructor.
     * @param Standing $resource
     * @param Team $team
     */
    public function __construct(Standing $resource, Team $team)
    {
        $this->resource = $resource;
        $this->team = $team;
    }

    /**
     * Create initial data
     */
    public function create(): void
    {
        $standings = $this->resource->all();

        if ($standings->isNotEmpty()) {
            return;
        }

        $teamIds = $this->team->get()->pluck('id');

        foreach ($teamIds as $teamId) {
            $this->resource->create(['team_id' => $teamId]);
        }
    }

    /**
     * Truncate table for reset action
     */
    public function truncate(): void
    {
        $this->resource::query()->truncate();
    }

    /**
     * @param $team_id
     * @return mixed
     */
    public function getStandingByTeamId($team_id)
    {
        return $this->resource->where('team_id', $team_id)->first();
    }

    /**
     * @return mixed
     */
    public function checkStandingStatus()
    {
        return $this->resource->select('played')->first();
    }
}
