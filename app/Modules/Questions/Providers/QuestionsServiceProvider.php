<?php

namespace App\Modules\Questions\Providers;

use App\Repositories\IQuestionsRepo;
use App\Repositories\QuestionsRepo;
use Illuminate\Support\ServiceProvider;

class QuestionsServiceProvider extends ServiceProvider
{

    public $bindings = [
        IQuestionsRepo::class => QuestionsRepo::class,
    ];

}
