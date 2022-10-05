<?php

use App\Modules\Tests\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api', 'scope:user,admin,super-admin']], function () {
    Route::get("/test/data/{lesson}", [TestController::class, "getTestData"]);
    Route::post("/test/submit", [TestController::class, "submitTest"]);
});

Route::group(['middleware' => ['auth:api', 'scope:admin,super-admin']], function () {
    Route::resource('tests', TestController::class);
    Route::get("/test/status/{test}", [TestController::class, "testRequirements"]);
});
