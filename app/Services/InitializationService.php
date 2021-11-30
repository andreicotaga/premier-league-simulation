<?php

namespace App\Services;

use App\Builders\HomeAndAwayBuilder;
use App\Contracts\InitializationServiceInterface;
use App\Contracts\MatchRepositoryInterface;
use App\Contracts\StandingRepositoryInterface;
use App\Contracts\TeamRepositoryInterface;
use App\Contracts\WeekRepositoryInterface;

/**
 * Class InitializationService
 * @package App\Services
 */
class InitializationService implements InitializationServiceInterface
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
     * @var TeamRepositoryInterface
     */
    protected $teamRepository;

    /**
     * @var WeekRepositoryInterface
     */
    protected $weekRepository;

    /**
     * InitializationService constructor.
     * @param MatchRepositoryInterface $matchRepository
     * @param StandingRepositoryInterface $standingRepository
     * @param TeamRepositoryInterface $teamRepository
     * @param WeekRepositoryInterface $weekRepository
     */
    public function __construct(
        MatchRepositoryInterface $matchRepository,
        StandingRepositoryInterface $standingRepository,
        TeamRepositoryInterface $teamRepository,
        WeekRepositoryInterface $weekRepository
    )
    {
        $this->matchRepository = $matchRepository;
        $this->standingRepository = $standingRepository;
        $this->teamRepository = $teamRepository;
        $this->weekRepository = $weekRepository;
    }

    /**
     * Create default initial data
     */
    public function create(): void
    {
        $this->standingRepository->create();

        $teamIds = $this->teamRepository->getTeamIds();

        $homeAndAwayBuilder = new HomeAndAwayBuilder($teamIds);
        $this->matchRepository->create($homeAndAwayBuilder->fixtures());
    }

    /**
     * Get all teams with their standings
     *
     * @return array
     */
    public function getAllTeamsWithStandings(): array
    {
        $teamsStanding = $this->teamRepository->getTeamsWithStandings()->toArray();

        $data = [];
        foreach ($teamsStanding as $value) {
            $data[] = [
                'team_name' => $value['name'],
                'points' => $value['standing']['points'],
                'won' => $value['standing']['won'],
                'draw' => $value['standing']['draw'],
                'lose' => $value['standing']['lose'],
                'goal_drawn' => $value['standing']['goal_drawn'],
                'played' => $value['standing']['played'],
            ];
        }

        return $data;
    }

    /**
     * Get all weeks
     *
     * @return array
     */
    public function getWeeks(): array
    {
        return $this->weekRepository->get()->pluck(['id', 'name'])->toArray();
    }

    /**
     * Get initial fixtures
     *
     * @return array
     */
    public function getFixtures(): array
    {
        return $this->matchRepository->getFixture();
    }

    /**
     * Truncate and re-create data
     */
    public function reset(): void
    {
        $this->standingRepository->truncate();
        $this->matchRepository->truncate();

        $this->create();
    }
}
