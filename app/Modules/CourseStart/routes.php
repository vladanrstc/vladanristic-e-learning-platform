<?php

use App\Modules\CourseStart\Controllers\CourseStartController;
use Illuminate\Support\Facades\Route;

//Route::group(['middleware' => ['scope:user,admin,super-admin']], function () {
    Route::resource('user_courses_started', CourseStartController::class);

    // started and not started courses
    Route::get("/courses/started", [CourseStartController::class, "courses_started"]);
    Route::get("/courses/not-started", [CourseStartController::class, "courses_not_started"]);
//});


