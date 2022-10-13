<?php

namespace App\Modules\Lessons;

use App\Modules\Lessons\Controllers\LessonsController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api', 'scope:admin,super-admin']], function () {

    Route::resource('lessons', LessonsController::class);
    Route::post("/lessons/update/{lesson}", [LessonsController::class, "update"]);
    Route::get("/lessons/section/{section}", [LessonsController::class, "sectionLessons"]);
    Route::post("/lessons/order", [LessonsController::class, "changeLessonsOrder"]);
    Route::post("/lessons/switch", [LessonsController::class, "toggleLessonPublished"]);
    Route::post("/lessons/video", [LessonsController::class, "attachLessonVideo"]);

});
