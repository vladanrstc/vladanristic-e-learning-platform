<?php

use App\Modules\Auth\Controllers\ForgotPasswordController;
use App\Modules\Auth\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("/user/verify/{token}", [RegisterController::class, "verify"]);
Route::get("/user/reset-password/{token}", [ForgotPasswordController::class, "showForm"]);
Route::post("/user/reset-password/final", [ForgotPasswordController::class, "updatePassword"]);
