<?php


use App\Modules\Answers\Controllers\AnswerController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:api', 'scope:admin,super-admin']], function () {

    // store
    Route::post("store", [AnswerController::class, "store"]);

    // update
    Route::put("{answer}/update", [AnswerController::class, "update"]);

    // delete
    Route::delete("{answer}/delete", [AnswerController::class, "destroy"]);

});
