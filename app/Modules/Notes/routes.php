<?php

use App\Modules\Notes\Controllers\NotesController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api', 'scope:user,admin,super-admin']], function () {
    Route::get("/course/{course}", [NotesController::class, "getCourseNotes"]);
    Route::patch("/courses/started/notes", [NotesController::class, "updateCourseNote"]);
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth:api', 'scope:admin,super-admin']], function () {

    Route::delete("{courseStart}/delete", [NotesController::class, "destroy"]);

    Route::get("/course/{course}", [NotesController::class, "courseNotes"]);
});


