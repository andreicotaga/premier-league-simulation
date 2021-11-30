<?php

namespace App\Builders;

use App\Contracts\MatchRepositoryInterface;
use App\Contracts\StandingRepositoryInterface;

class PredictionBuilder
{
    /**
     * @var StandingRepositoryInterface
     */
    protected $standingRepository;

    /**
     * @var MatchRepositoryInterface
     */
    protected $matchRepository;

    /**
     * PredictionBuilder constructor.
     * @param StandingRepositoryInterface $standingRepository
     * @param MatchRepositoryInterface $matchRepository
     */
    public function __construct(StandingRepositoryInterface $standingRepository, MatchRepositoryInterface $matchRepository)
    {
        $this->standingRepository = $standingRepository;
        $this->matchRepository = $matchRepository;
    }

    /**
     * Get prediction
     *
     * @return array
     */
    public function prediction(): array
    {
        $finished = $this->standingRepository->all();

        $played = $this->standingRepository->checkStandingStatus();
        if ($played->played == 0 || $played->played == 6) {
            return [];
        }

        $teams = $this->collectionPredictions($finished);

        $remainedPoints = 3 * (6 - $teams[1]['played']);
        $topTeamPoint   = $teams[1]['points'];

        $rawPrediction = [];
        foreach ($teams as $rank => $team) {
            $rawPrediction[$team['team_name']] = $this->calculateTeamChance($team, $rank, $remainedPoints,
                $topTeamPoint);
        }

        return $this->calculateChanceInPercentage($rawPrediction);
    }

    /**
     * Calculate chance in percentage
     *
     * @param $rawPrediction
     * @return array
     */
    public function calculateChanceInPercentage($rawPrediction): array
    {
        $onePointPercent = 100 / array_sum($rawPrediction);

        $chanceInPercentage = [];
        foreach ($rawPrediction as $teamId => $teamChance) {
            $chanceInPercentage[$teamId] = round($teamChance * $onePointPercent, 2);
        }

        return $chanceInPercentage;
    }

    /**
     * Calculate team chance
     *
     * @param $team
     * @param $rank
     * @param $remainedPoints
     * @param $topTeamPoint
     * @return float|int
     */
    public function calculateTeamChance($team, $rank, $remainedPoints, $topTeamPoint)
    {
        if ($remainedPoints + $team['points'] < $topTeamPoint) {
            return 0;
        }

        $homeChance = 0;
        $awayChance = 0;

        $matches = $this->matchRepository->getAllMatchesByTeamId($team['team_id']);

        foreach ($matches as $match) {
            if ($match->home_team == $team['team_id']) {
                $homeChance += 2;
            }

            if ($match->away_team == $team['team_id']) {
                $awayChance += 1;
            }
        }

        $chanceByRemainedMatches = ($homeChance + $awayChance);
        $chanceIncludingCurrentRank = $chanceByRemainedMatches - ($rank / 2);
        $chanceIncludingPointsDifference = $chanceIncludingCurrentRank - (($topTeamPoint - $team['points']) / 2);

        return $chanceIncludingPointsDifference > 0 ? $chanceIncludingPointsDifference : 0;
    }

    /**
     * Calculate predictions
     *
     * @param $data
     * @return array
     */
    private function collectionPredictions($data): array
    {
        $teams = [];
        foreach ($data as $value) {
            $teams[$value->team_id]['points'] = $value->points;
            $teams[$value->team_id]['played'] = $value->played;
            $teams[$value->team_id]['team_id'] = $value->team_id;
            $teams[$value->team_id]['team_name'] = $value->name;
        }

        return $teams;
    }
}
