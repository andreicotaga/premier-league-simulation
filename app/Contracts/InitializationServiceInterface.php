<?php

namespace App\Contracts;

interface InitializationServiceInterface
{
    /**
     * Create default initial data
     */
    public function create(): void;

    /**
     * Truncate data
     */
    public function reset(): void;

    /**
     * Get all teams with standings
     *
     * @return array
     */
    public function getAllTeamsWithStandings(): array;

    /**
     * Get weeks
     *
     * @return array
     */
    public function getWeeks(): array;
}
