<?php

namespace App\Repositories;

use App\Contracts\StandingRepositoryInterface;
use App\Models\Standing;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

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
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->team->leftJoin('standings', 'teams.id', '=', 'standings.team_id')
            ->orderBy('standings.points', 'DESC')
            ->orderBy('standings.goal_drawn', 'DESC')
            ->orderBy('standings.won', 'DESC')
            ->get();
    }

    /**
     * Truncate table for reset action
     */
    public function truncate(): void
    {
        $this->resource::query()->truncate();
    }

    /**
     * Get standing by team id
     *
     * @param $team_id
     * @return mixed
     */
    public function getStandingByTeamId($team_id)
    {
        return $this->resource->where('team_id', $team_id)->first();
    }

    /**
     * Check standing status
     *
     * @return mixed
     */
    public function checkStandingStatus()
    {
        return $this->resource->select('played')->first();
    }
}
