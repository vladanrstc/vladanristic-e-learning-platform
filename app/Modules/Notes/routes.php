<?php

use App\Modules\Notes\Controllers\NotesController;
use Illuminate\Support\Facades\Route;

//    Route::group(['middleware' => ['scope:user,admin,super-admin']], function () {
    Route::get("/courses/started/{course}", [NotesController::class, "getCourseNotes"]);
//});

