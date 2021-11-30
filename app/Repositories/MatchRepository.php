<?php

namespace App\Repositories;

use App\Contracts\MatchRepositoryInterface;
use App\Models\Match;
use App\Models\Team;
use App\Models\Week;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class MatchRepository
 * @package App\Repositories
 */
class MatchRepository implements MatchRepositoryInterface
{
    /**
     * @var Team
     */
    protected $team;

    /**
     * @var Match
     */
    protected $resource;

    /**
     * @var Week
     */
    protected $week;

    /**
     * MatchRepository constructor.
     * @param Team $team
     * @param Match $resource
     * @param Week $week
     */
    public function __construct(Team $team, Match $resource, Week $week)
    {
        $this->team  = $team;
        $this->resource = $resource;
        $this->week  = $week;
    }

    /**
     * Truncate table for reset action
     */
    public function truncate(): void
    {
        $this->resource::query()->truncate();
    }

    /**
     * @return mixed
     */
    public function getTeamsId()
    {
        return $this->team->pluck('id')->toArray();
    }

    /**
     * @return mixed
     */
    public function getWeeksId()
    {
        return $this->week->pluck('id');
    }

    /**
     * @param $fixtures
     */
    public function create($fixtures): void
    {
        $matches = $this->resource->all();

        if ($matches->isNotEmpty()) {
            return;
        }

        foreach ($fixtures as $fixture) {
            $this->resource->create([
                'home_team' => $fixture['home'],
                'away_team' => $fixture['away'],
                'week_id' => $fixture['week']
            ]);
        }
    }

    /**
     * @return array
     */
    public function getFixture(): array
    {
        return $this->resource->select(
            'matches.id',
            'matches.played',
            'matches.week_id',
            'matches.home_team_goal',
            'matches.away_team_goal',
            'weeks.name as week_name',
            'home.name as home_team',
            'away.name as away_team')
            ->join('weeks', 'weeks.id', '=', 'matches.week_id')
            ->join('teams as home', 'home.id', '=', 'matches.home_team')
            ->join('teams as away', 'away.id', '=', 'matches.away_team')
            ->orderBy('week_id', 'ASC')
            ->get()
            ->groupBy('week_id')
            ->toArray();
    }

    /**
     * @param $week_id
     * @return mixed
     */
    public function getFixtureByWeekId($week_id): Collection
    {
        return $this->resource->select(
            'matches.id',
            'matches.played',
            'matches.week_id',
            'matches.home_team_goal',
            'matches.away_team_goal',
            'week_id',
            'weeks.name as week_name',
            'home.name as home_team',
            'away.name as away_team')
            ->join('weeks', 'weeks.id', '=', 'matches.week_id')
            ->join('teams as home', 'home.id', '=', 'matches.home_team')
            ->join('teams as away', 'away.id', '=', 'matches.away_team')
            ->where('matches.week_id', '=', $week_id)
            ->orderBy('matches.id', 'ASC')
            ->get();
    }

    /**
     * @param int $weekId
     * @return mixed
     */
    public function getMatchesByWeek(int $weekId)
    {
        return $this->resource->where([['week_id', '=', $weekId], ['played', '=', 0]])->get();
    }

    /**
     * Get all not played matches
     *
     * @param int $played
     * @return mixed
     */
    public function getAllMatches(int $played = 0): Collection
    {
        return $this->resource->where('played', '=', $played)->get();
    }

    /**
     * @param $teamId
     * @return mixed
     */
    public function getAllMatchesByTeamId($teamId)
    {
        return $this->resource
            ->where(function ($q) use ($teamId) {
                $q->where('home_team', '=', $teamId)
                    ->orWhere('away_team', '=', $teamId);
            })
            ->where('played', '=', 0)
            ->get();
    }

    /**
     * Update match score
     *
     * @param $homeScore
     * @param $awayScore
     * @param $home
     * @param $away
     */
    public function update($homeScore, $awayScore, $home, $away)
    {
        $goalDrawn = abs($awayScore - $homeScore);

        if ($homeScore > $awayScore) {
            $home->won($goalDrawn);
            $away->lose($goalDrawn);

        } elseif ($awayScore > $homeScore) {
            $away->won($goalDrawn);
            $home->lose($goalDrawn);
        } else {
            $home->draw();
            $away->draw();
        }

        $home->save();
        $away->save();
    }

    /**
     * Save match score
     *
     * @param $match
     * @param $homeScore
     * @param $awayScore
     * @return mixed
     */
    public function save($match, $homeScore, $awayScore)
    {
        $match->home_team_goal = $homeScore;
        $match->away_team_goal = $awayScore;
        $match->played = 1;

        return $match->save();
    }
}
