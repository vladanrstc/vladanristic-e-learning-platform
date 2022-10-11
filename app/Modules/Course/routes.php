<?php

use App\Modules\Course\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::get("/all", [CourseController::class, "allCourses"]);
Route::get("/details/{course}", [CourseController::class, "courseDetails"]);

Route::group(['middleware' => ['auth:api', 'scope:user']], function () {
    Route::get("/user-details/{course}", [CourseController::class, "courseDetails"]);
});

Route::group(['middleware' => ['auth:api', 'scope:admin,super-admin']], function () {
    Route::resource('courses', CourseController::class);
    Route::post("/courses/update/{course}", [CourseController::class, "update"]);
});

