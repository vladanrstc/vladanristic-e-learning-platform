<?php

namespace App\Modules\Answers\Providers;

use App\Repositories\AnswersRepo;
use App\Repositories\IAnswersRepo;
use Illuminate\Support\ServiceProvider;

class AnswersServiceProvider extends ServiceProvider
{

    public $bindings = [
        IAnswersRepo::class => AnswersRepo::class
    ];

}
