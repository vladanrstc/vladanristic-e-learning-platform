<?php

use App\Modules\Sections\Controllers\SectionController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api', 'scope:user,admin,super-admin']], function () {
    Route::resource('', SectionController::class);
    Route::get("/course/{course}", [SectionController::class, "courseSections"]);
    Route::post("/order", [SectionController::class, "sectionsReorder"]);
});
