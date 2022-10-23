<?php

namespace App\Modules\Stats\Providers;

use App\Modules\Stats\Services\IStatsService;
use App\Modules\Stats\Services\StatsServiceImpl;
use Illuminate\Support\ServiceProvider;

class StatsServiceProvider extends ServiceProvider
{

    public $bindings = [
        IStatsService::class => StatsServiceImpl::class
    ];

}
