<?php

namespace App\Modules\Questions\Providers;

use App\Modules\Questions\Services\IQuestionsService;
use App\Modules\Questions\Services\QuestionsServiceImpl;
use Illuminate\Support\ServiceProvider;

class QuestionsServiceProvider extends ServiceProvider
{

    public $bindings = [
        IQuestionsService::class => QuestionsServiceImpl::class,
    ];

}
