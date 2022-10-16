<?php

use App\Modules\Questions\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:api', 'scope:admin,super-admin']], function () {

    // store
    Route::post("store", [QuestionController::class, "store"]);

    // update
    Route::put("{question}/update", [QuestionController::class, "update"]);

    // delete
    Route::delete("{question}/delete", [QuestionController::class, "destroy"]);

    Route::get("/test/{test}", [QuestionController::class, "testQuestions"]);

});

