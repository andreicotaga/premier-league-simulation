<?php

namespace App\Builders;

use App\Contracts\MatchRepositoryInterface;
use App\Contracts\StandingRepositoryInterface;

class MatchSimulationBuilder
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
     * MatchSimulationBuilder constructor.
     * @param StandingRepositoryInterface $standingRepository
     * @param MatchRepositoryInterface $matchRepository
     */
    public function __construct(StandingRepositoryInterface $standingRepository, MatchRepositoryInterface $matchRepository)
    {
        $this->standingRepository = $standingRepository;
        $this->matchRepository = $matchRepository;
    }

    /**
     * Simulate a match
     *
     * @param $match
     * @return mixed
     */
    public function simulate($match)
    {
        $home = $this->standingRepository->getStandingByTeamId($match->home_team);
        $away = $this->standingRepository->getStandingByTeamId($match->away_team);

        $homeScore = $this->generateScore(true, $home->id);
        $awayScore = $this->generateScore(false, $away->id);

        $this->updateMatchScore($homeScore, $awayScore, $home, $away);

        return $this->matchRepository->save($match, $homeScore, $awayScore);
    }

    /**
     * Simulate all matches
     *
     * @param $matches
     */
    public function simulateAll($matches)
    {
        foreach ($matches as $match) {
            $this->simulate($match);
        }
    }

    /**
     * Update match score
     *
     * @param $homeScore
     * @param $awayScore
     * @param $home
     * @param $away
     */
    public function updateMatchScore($homeScore, $awayScore, $home, $away): void
    {
        $this->matchRepository->update($homeScore, $awayScore, $home, $away);
    }

    /**
     * Generate random score based on team rank
     *
     * @param bool $isHome
     * @param int $teamRank
     * @return int
     */
    private function generateScore(bool $isHome, int $teamRank): int
    {
        return $isHome ? rand(0, 10) : rand(0, 10 - $teamRank);
    }
}
