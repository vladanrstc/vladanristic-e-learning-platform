<?php

use App\Modules\Sections\Controllers\SectionController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api', 'scope:user,admin,super-admin']], function () {
    Route::resource('sections', SectionController::class);
    Route::get("/sections/course/{course}", [SectionController::class, "courseSections"]);
    Route::post("/sections/order", [SectionController::class, "sectionsReorder"]);
});
