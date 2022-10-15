<?php

use App\Modules\CourseStart\Controllers\CourseStartController;
use App\Modules\CourseStart\Controllers\LessonCompletedController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api,scope:user,admin,super-admin']], function () {
    Route::post('/enroll', [CourseStartController::class, "enrollInCourse"]);

    // started and not started courses
    Route::get("/started", [CourseStartController::class, "coursesStarted"]);
    Route::get("/not-started", [CourseStartController::class, "coursesNotStarted"]);

    Route::get("/lesson/finish/{lessonId}", [LessonCompletedController::class, "finishLesson"]);
});
