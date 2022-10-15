<?php

use App\Modules\Sections\Controllers\SectionController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api', 'scope:user,admin,super-admin']], function () {
    Route::get("/course/{course}", [SectionController::class, "courseSections"]);
    Route::post("/order", [SectionController::class, "sectionsReorder"]);

    // store
    Route::post("store", [SectionController::class, "store"]);

    // update
    Route::put("{section}/update", [SectionController::class, "update"]);

    // delete
    Route::delete("{section}/delete", [SectionController::class, "destroy"]);

});
