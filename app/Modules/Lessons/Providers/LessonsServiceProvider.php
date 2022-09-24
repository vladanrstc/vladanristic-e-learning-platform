<?php

namespace App\Modules\Lessons\Providers;

use App\Modules\CourseStart\Services\CourseStartServiceImpl;
use App\Modules\CourseStart\Services\ICourseStartService;
use App\Modules\Coursestart\Services\ILessonFinishService;
use App\Modules\Coursestart\Services\LessonFinishServiceImpl;
use App\Modules\Lessons\Services\ILessonsService;
use App\Modules\Lessons\Services\LessonsServiceImpl;
use Illuminate\Support\ServiceProvider;

class LessonsServiceProvider extends ServiceProvider
{

    public $bindings = [
        ILessonsService::class  => LessonsServiceImpl::class
    ];

}
