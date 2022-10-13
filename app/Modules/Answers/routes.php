<?php


use App\Modules\Answers\Controllers\AnswerController;
use Illuminate\Support\Facades\Route;

//    Route::group(['middleware' => ['scope:admin,super-admin']], function () {

Route::resource('answers', AnswerController::class);

//    });
