<?php

use App\Modules\Sections\Controllers\SectionController;
use Illuminate\Support\Facades\Route;

//    Route::group(['middleware' => ['scope:admin,super-admin']], function () {
    Route::resource('sections', SectionController::class);
    Route::get("/sections/course/{course}", [SectionController::class, "course_sections"]);
    Route::post("/sections/order", [SectionController::class, "sections_order"]);
//});
