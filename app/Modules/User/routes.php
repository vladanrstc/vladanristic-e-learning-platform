<?php

use App\Modules\User\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['scope:super-admin']], function () {
    Route::resource('users', UserController::class);
    Route::delete("/users/ban/{user}", [UserController::class, "ban_user"]);
    Route::get("/users-banned", [UserController::class, "banned_users"]);
    Route::get("/users/unban/{user}", [UserController::class, "unban_user"]);
});
