<?php

use App\Modules\Reviews\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get("/course/{courseSlug}", [ReviewController::class, "getCourseReviews"]);

Route::group(['middleware' => ['auth:api', 'scope:user,admin,super-admin']], function () {
    Route::patch("/courses/started/review", [ReviewController::class, "updateCourseReview"]);
    Route::get("/course/user/{course}", [ReviewController::class, "course_reviews_user"]);
});

Route::group(['middleware' => ['auth:api', 'scope:admin,super-admin']], function () {
    Route::resource('', ReviewController::class);
    Route::get("/course/{course}/all", [ReviewController::class, "allCourseReviews"]);
});
