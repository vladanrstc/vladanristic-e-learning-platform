<?php

namespace App\Modules\CourseStart\Providers;

use App\Modules\CourseStart\Services\CourseStartServiceImpl;
use App\Modules\CourseStart\Services\ICourseStartService;
use App\Modules\Coursestart\Services\ILessonFinishService;
use App\Modules\Coursestart\Services\LessonFinishServiceImpl;
use Illuminate\Support\ServiceProvider;

class CourseStartServiceProvider extends ServiceProvider
{

    public $bindings = [
        ICourseStartService::class  => CourseStartServiceImpl::class,
        ILessonFinishService::class => LessonFinishServiceImpl::class
    ];

}
