<?php

namespace App\Modules\Lessons;

use App\Modules\Lessons\Controllers\LessonsController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api', 'scope:admin,super-admin']], function () {

    // store
    Route::post("store", [LessonsController::class, "store"]);

    // update
    Route::post("{lesson}/update", [LessonsController::class, "update"]);

    // delete
    Route::delete("{lesson}/delete", [LessonsController::class, "destroy"]);

    Route::post("/update/{lesson}", [LessonsController::class, "update"]);
    Route::get("/section/{section}", [LessonsController::class, "sectionLessons"]);
    Route::post("/order", [LessonsController::class, "changeLessonsOrder"]);
    Route::post("/switch", [LessonsController::class, "toggleLessonPublished"]);
    Route::post("/video", [LessonsController::class, "attachLessonVideo"]);

});
