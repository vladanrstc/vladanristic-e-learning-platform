<?php

use App\Modules\User\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api', 'scope:super-admin']], function () {
    Route::resource('users', UserController::class);
    Route::delete("/ban/{user}", [UserController::class, "banUser"]);
    Route::get("/users-banned", [UserController::class, "bannedUsers"]);
    Route::get("/unban/{user}", [UserController::class, "unbanUser"]);
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::get("/logged", [UserController::class, "loggedUser"]);
    Route::patch("/logged", [UserController::class, "updateLoggedUser"]);
});
