<?php

namespace App\Services;

use App\Builders\MatchSimulationBuilder;
use App\Contracts\MatchRepositoryInterface;
use App\Contracts\SimulationServiceInterface;
use App\Contracts\StandingRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class SimulationService
 * @package App\Services
 */
class SimulationService implements SimulationServiceInterface
{
    /**
     * @var MatchRepositoryInterface
     */
    protected $matchRepository;

    /**
     * @var StandingRepositoryInterface
     */
    protected $standingRepository;


    /**
     * SimulationService constructor.
     * @param MatchRepositoryInterface $matchRepository
     * @param StandingRepositoryInterface $standingRepository
     */
    public function __construct(
        MatchRepositoryInterface $matchRepository,
        StandingRepositoryInterface $standingRepository
    )
    {
        $this->matchRepository = $matchRepository;
        $this->standingRepository = $standingRepository;
    }

    /**
     * Play specific week
     *
     * @param int $weekId
     * @return mixed
     */
    public function play(int $weekId): Collection
    {
        $matches = $this->matchRepository->getMatchesByWeek($weekId);
        (new MatchSimulationBuilder($this->standingRepository, $this->matchRepository))->simulateAll($matches);

        return $this->matchRepository->getFixtureByWeekId($weekId);
    }

    /**
     * Play all matches
     *
     * @throws Exception
     */
    public function playAll(): void
    {
        $matches = $this->matchRepository->getAllMatches();

        try {
            (new MatchSimulationBuilder($this->standingRepository, $this->matchRepository))->simulateAll($matches);
        } catch (Exception $exception) {
            throw new Exception('Something went wrong on playing all matches.', ['message' => $exception->getMessage()]);
        }
    }
}
