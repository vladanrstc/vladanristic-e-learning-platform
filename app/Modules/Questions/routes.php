<?php

use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

//    Route::group(['middleware' => ['scope:admin,super-admin']], function () {

    Route::resource('questions', QuestionController::class);
    Route::get("/questions/test/{test}", [QuestionController::class, "test_questions"]);

//});
