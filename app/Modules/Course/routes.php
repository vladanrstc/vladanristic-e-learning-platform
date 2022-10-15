<?php

use App\Modules\Course\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::get("/all", [CourseController::class, "allCourses"]);
Route::get("/details/{course}", [CourseController::class, "courseDetails"]);

Route::group(['middleware' => ['auth:api', 'scope:user']], function () {
    Route::get("/user-details/{course}", [CourseController::class, "courseDetails"]);
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth:api', 'scope:admin,super-admin']], function () {

    Route::get("all-courses", [CourseController::class, "index"]);

    // store
    Route::post("store", [CourseController::class, "store"]);

    // update
    Route::post("{course}/update", [CourseController::class, "update"]);

    // delete
    Route::delete("{course}/delete", [CourseController::class, "destroy"]);

});

