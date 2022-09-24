<?php

namespace App\Providers;

use App\Repositories\AnswersRepo;
use App\Repositories\CoursesRepo;
use App\Repositories\CourseStartRepo;
use App\Repositories\IAnswersRepo;
use App\Repositories\ICoursesRepo;
use App\Repositories\ICourseStartRepo;
use App\Repositories\ILessonsRepo;
use App\Repositories\IQuestionsRepo;
use App\Repositories\ISectionsRepo;
use App\Repositories\LessonsRepo;
use App\Repositories\QuestionsRepo;
use App\Repositories\SectionsRepo;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public array $bindings = [
        ICourseStartRepo::class => CourseStartRepo::class,
        ICoursesRepo::class     => CoursesRepo::class,
        ISectionsRepo::class    => SectionsRepo::class,
        ILessonsRepo::class     => LessonsRepo::class,
        IQuestionsRepo::class   => QuestionsRepo::class,
        IAnswersRepo::class     => AnswersRepo::class
    ];

}
