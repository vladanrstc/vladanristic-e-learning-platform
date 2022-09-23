<?php

namespace App\Providers;

use App\Repositories\CoursesRepo;
use App\Repositories\CourseStartRepo;
use App\Repositories\ICoursesRepo;
use App\Repositories\ICourseStartRepo;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public $bindings = [
        ICourseStartRepo::class => CourseStartRepo::class,
        ICoursesRepo::class     => CoursesRepo::class
    ];

}
