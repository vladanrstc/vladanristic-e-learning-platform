<?php

use App\Modules\Tests\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api', 'scope:user,admin,super-admin']], function () {
    Route::get("/data/{lesson}", [TestController::class, "getTestData"]);
    Route::post("/submit", [TestController::class, "submitTest"]);
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth:api', 'scope:admin,super-admin']], function () {
    Route::resource('tests', TestController::class);

    // show
    Route::get("{test}/show", [TestController::class, "show"]);

    // store
    Route::post("store", [TestController::class, "store"]);

    // update
    Route::put("{test}/update", [TestController::class, "update"]);

    // delete
    Route::delete("{test}/delete", [TestController::class, "destroy"]);

});
