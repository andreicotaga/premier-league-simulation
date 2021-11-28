<?php

namespace App\Contracts;

interface MatchRepositoryInterface
{
    /**
     * Create initial data
     */
    public function create($fixtures): void;

    /**
     * Truncate table for reset action
     */
    public function truncate(): void;
}
