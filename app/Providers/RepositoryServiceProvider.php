<?php

namespace App\Providers;

use App\Contracts\MatchRepositoryInterface;
use App\Contracts\StandingRepositoryInterface;
use App\Contracts\TeamRepositoryInterface;
use App\Contracts\WeekRepositoryInterface;
use App\Repositories\MatchRepository;
use App\Repositories\StandingRepository;
use App\Repositories\TeamRepository;
use App\Repositories\WeekRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 * @package App\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @var string[]
     */
    public $singletons = [
        MatchRepositoryInterface::class => MatchRepository::class,
        StandingRepositoryInterface::class => StandingRepository::class,
        TeamRepositoryInterface::class => TeamRepository::class,
        WeekRepositoryInterface::class => WeekRepository::class,
    ];
}
