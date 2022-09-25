<?php

use App\Modules\Tests\Controllers\TestController;
use Illuminate\Support\Facades\Route;

//    Route::group(['middleware' => ['scope:user,admin,super-admin']], function () {

Route::get("/test/data/{lesson}", [TestController::class, "getTestData"]);
Route::post("/test/submit/{test}", [TestController::class, "submitTest"]);

//    });

//    Route::group(['middleware' => ['scope:admin,super-admin']], function () {

Route::resource('tests', TestController::class);
Route::get("/test/status/{test}", [TestController::class, "testRequirements"]);
//    });
