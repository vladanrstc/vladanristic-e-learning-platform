<?php

namespace App\Modules\Sections\Providers;

use App\Modules\Sections\Services\ISectionsService;
use App\Modules\Sections\Services\SectionsServiceImpl;
use Illuminate\Support\ServiceProvider;

class SectionServiceProvider extends ServiceProvider
{

    public $bindings = [
        ISectionsService::class => SectionsServiceImpl::class,
    ];

}
