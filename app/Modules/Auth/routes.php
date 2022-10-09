<?php

use App\Modules\Auth\Controllers\ForgotPasswordController;
use App\Modules\Auth\Controllers\LoginController;
use App\Modules\Auth\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post("/reset-password", [ForgotPasswordController::class, "sendResetMail"]);
Route::post('/login', [LoginController::class, "login"]);
Route::post('/register', [RegisterController::class, "register"]);

Route::group(['middleware' => ['auth:api', 'scope:admin,super-admin']], function () {
    Route::get("/check-admin", function () {
        return response()->json([]);
    });
});
