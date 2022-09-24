<?php

namespace App\Modules\Tests\Providers;

use App\Modules\Tests\Services\ITestsService;
use App\Modules\Tests\Services\TestsServiceImpl;
use Illuminate\Support\ServiceProvider;

class TestsServiceProvider extends ServiceProvider
{

    public $bindings = [
        ITestsService::class => TestsServiceImpl::class,
    ];

}
