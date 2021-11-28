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
}
