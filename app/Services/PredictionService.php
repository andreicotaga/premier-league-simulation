<?php

namespace App\Services;

use App\Builders\PredictionBuilder;
use App\Contracts\MatchRepositoryInterface;
use App\Contracts\PredictionServiceInterface;
use App\Contracts\StandingRepositoryInterface;

class PredictionService implements PredictionServiceInterface
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
     * Get prediction
     *
     * @return array
     */
    public function getPrediction(): array
    {
        return (new PredictionBuilder($this->standingRepository, $this->matchRepository))->prediction();
    }
}
