<?php

use App\Modules\Tests\Controllers\TestController;
use Illuminate\Support\Facades\Route;

//    Route::group(['middleware' => ['scope:user,admin,super-admin']], function () {

Route::get("/test/data/{lesson}", [TestController::class, "get_test_data"]);
Route::post("/test/submit/{test}", [TestController::class, "submit_test"]);

//    });

//    Route::group(['middleware' => ['scope:admin,super-admin']], function () {

Route::resource('tests', TestController::class);
Route::get("/test/status/{test}", [TestController::class, "test_requirements"]);
//    });
