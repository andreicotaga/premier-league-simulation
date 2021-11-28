<?php

namespace App\Builders;

/**
 * Class HomeAndAwayBuilder
 * @package App\Builders
 */
class HomeAndAwayBuilder
{
    /**
     * @var array
     */
    private $teamIds;

    /**
     * @var integer
     */
    private $teamIdsCount;

    /**
     * HomeAndAwayBuilder constructor.
     * @param array $teamIds
     */
    public function __construct(array $teamIds)
    {
        $this->teamIds = $teamIds;
        shuffle($this->teamIds);
        $this->teamIdsCount = count($this->teamIds);
    }

    /**
     * @return array
     */
    public function fixtures(): array
    {
        $numberOfWeeks = $this->getNumberOfWeeks($this->teamIdsCount);
        $numberOfWeeklyFixtures = $this->getNumberOfWeeklyFixtures($this->teamIdsCount);

        $allFixtures = $this->makeAllFixtures();

        shuffle($allFixtures);

        $weeklyFixtures = $this->makeWeeklyFixtures($numberOfWeeks, $numberOfWeeklyFixtures, $allFixtures);

        return $this->flatFixtures($weeklyFixtures);
    }

    /**
     * @return array
     */
    public function makeAllFixtures(): array
    {
        $fixtures = [];
        foreach ($this->teamIds as $homeTeamId) {
            foreach ($this->teamIds as $awayTeamId) {
                if ($homeTeamId === $awayTeamId) {
                    continue;
                }

                $fixtures[] = [
                    'home' => $homeTeamId,
                    'away' => $awayTeamId,
                    'used' => 0
                ];
            }
        }

        return $fixtures;
    }

    /**
     * @param $fixtures
     * @return array
     */
    public function flatFixtures($fixtures): array
    {
        $flatFixturesArray = [];
        $allWeekFixtures = array_values($fixtures);
        foreach ($allWeekFixtures as $weekFixtures) {
            foreach ($weekFixtures as $fixture) {
                $flatFixturesArray[] = $fixture;
            }
        }

        return $flatFixturesArray;
    }

    /**
     * @param int $numberOfWeeks
     * @param int $numberOfWeeklyFixtures
     * @param array $allFixtures
     * @return array
     */
    public function makeWeeklyFixtures(int $numberOfWeeks, int $numberOfWeeklyFixtures, array $allFixtures): array
    {
        $generatedWeeklyFixtures = [];

        for ($i = 1; $i <= $numberOfWeeks; $i++) {

            for ($j = 1; $j <= $numberOfWeeklyFixtures; $j++) {

                foreach ($allFixtures as &$fixture) {

                    if ($fixture['used'] === 1) {
                        continue;
                    }

                    $flag = false;
                    if (!count($generatedWeeklyFixtures) === 0 || array_key_exists($i, $generatedWeeklyFixtures)) {
                        $flag = $this->isMatchDuplicatedInWeek($fixture, $generatedWeeklyFixtures[$i], $i);
                    }

                    if ($flag) {
                        continue;
                    }

                    $generatedWeeklyFixtures[$i][] = [
                        'home' => $fixture['home'],
                        'away' => $fixture['away'],
                        'week' => $i,
                        'status' => 0
                    ];

                    $fixture['used'] = 1;
                    break;
                }
            }
        }

        return $generatedWeeklyFixtures;
    }

    /**
     * @param $fixture
     * @param $allFixtures
     * @return bool
     */
    public function isMatchDuplicatedInWeek($fixture, $allFixtures): bool
    {
        $response = false;
        foreach ($allFixtures as $f) {
            if (
            (
                ($fixture['home'] == $f['home'] || $fixture['home'] == $f['away']) ||
                ($fixture['away'] == $f['away'] || $fixture['away'] == $f['home'])
            )
            ) {
                $response = true;
                break;
            }
        }

        return $response;
    }

    /**
     * @param int $teamCount
     * @return float|int
     */
    public function getNumberOfWeeks(int $teamCount)
    {
        if ($teamCount % 2 == 0) {
            return ($teamCount - 1) * 2;
        }

        return ($teamCount - 1) / 2;
    }

    /**
     * @param int $teamCount
     * @return float|int
     */
    public function getNumberOfWeeklyFixtures(int $teamCount)
    {
        return $teamCount / 2;
    }
}
