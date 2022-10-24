<?php

namespace App\Providers;

use App\Adapters\LoggingAdapter;
use App\Lang\ILangHelper;
use App\Lang\LangHelper;
use App\Mails\IMailHandler;
use App\Mails\MailHandler;
use App\Modules\Auth\Controllers\LoginController;
use App\Modules\Auth\Services\LoginServiceImpl;
use App\Repositories\AnswersRepo;
use App\Repositories\CoursesRepo;
use App\Repositories\CourseStartRepo;
use App\Repositories\IAnswersRepo;
use App\Repositories\ICoursesRepo;
use App\Repositories\ICourseStartRepo;
use App\Repositories\ILessonCompletedRepo;
use App\Repositories\ILessonsRepo;
use App\Repositories\ILogsRepo;
use App\Repositories\IQuestionsRepo;
use App\Repositories\ISectionsRepo;
use App\Repositories\ITestsRepo;
use App\Repositories\IUsersRepo;
use App\Repositories\LessonCompletedRepo;
use App\Repositories\LessonsRepo;
use App\Repositories\QuestionsRepo;
use App\Repositories\SectionsRepo;
use App\Repositories\TestsRepo;
use App\Repositories\UsersRepo;
use App\ResponseFormatter\FormatterFactory;
use App\ResponseFormatter\IFormatterFactory;
use App\Utils\EntityOrderUtil;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public array $bindings = [
        IUsersRepo::class           => UsersRepo::class,
        ICourseStartRepo::class     => CourseStartRepo::class,
        ICoursesRepo::class         => CoursesRepo::class,
        ISectionsRepo::class        => SectionsRepo::class,
        ILessonsRepo::class         => LessonsRepo::class,
        ILessonCompletedRepo::class => LessonCompletedRepo::class,
        IQuestionsRepo::class       => QuestionsRepo::class,
        IAnswersRepo::class         => AnswersRepo::class,
        ITestsRepo::class           => TestsRepo::class,
        IMailHandler::class         => MailHandler::class,
        IFormatterFactory::class    => FormatterFactory::class,
        ILangHelper::class          => LangHelper::class
    ];

    public function register()
    {
        $this->app->singleton('ReorderEntities', function ($app) {
            return new EntityOrderUtil();
        });

        $this->app
            ->when(LoginServiceImpl::class)
            ->needs(ILogsRepo::class)
            ->give(LoggingAdapter::class);

    }

}
