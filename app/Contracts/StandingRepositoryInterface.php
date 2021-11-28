<?php

namespace App\Contracts;

interface StandingRepositoryInterface
{
    /**
     * Create initial data
     */
    public function create(): void;

    /**
     * Truncate table for reset action
     */
    public function truncate(): void;
}
