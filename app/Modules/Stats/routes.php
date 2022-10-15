<?php

use App\Modules\Stats\Controllers\StatsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:api', 'scope:admin,super-admin']], function () {
    Route::get("/overall-status", [StatsController::class, "generalStats"]);
});
Route::get("/last-three-videos", [StatsController::class, "lastThreeVideos"]);
