<?php

namespace App\Modules\Answers\Providers;

use App\Modules\Answers\Services\AnswersServiceImpl;
use App\Modules\Answers\Services\IAnswersService;
use Illuminate\Support\ServiceProvider;

class AnswersServiceProvider extends ServiceProvider
{

    public $bindings = [
        IAnswersService::class => AnswersServiceImpl::class
    ];

}
