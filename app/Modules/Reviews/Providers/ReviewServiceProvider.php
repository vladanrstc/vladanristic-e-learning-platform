<?php

namespace App\Modules\Reviews\Providers;

use App\Modules\Reviews\Services\IReviewsService;
use App\Modules\Reviews\Services\ReviewsServiceImpl;
use Illuminate\Support\ServiceProvider;

class ReviewServiceProvider extends ServiceProvider
{

    public $bindings = [
        IReviewsService::class => ReviewsServiceImpl::class,
    ];

}
