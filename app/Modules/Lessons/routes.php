<?php

namespace App\Modules\Lessons;

use App\Modules\Lessons\Controllers\LessonsController;
use Illuminate\Support\Facades\Route;

//    Route::group(['middleware' => ['scope:admin,super-admin']], function () {

    Route::resource('lessons', LessonsController::class);
    Route::post("/lessons/update/{lesson}", [LessonsController::class, "update"]);
    Route::get("/lessons/section/{section}", [LessonsController::class, "section_lessons"]);
    Route::post("/lessons/order", [LessonsController::class, "lessons_order"]);
    Route::post("/lessons/switch", [LessonsController::class, "lessons_switch"]);
    Route::post("/lessons/video", [LessonsController::class, "lessons_video"]);

//});
