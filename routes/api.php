<?php

//use App\Mail\ResetPassword;
use App\Mails\MailHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post("/message", function (Request $request) {
//    $t = new MailHandler::


//    Mail::to(
//        "vladanrstc@gmail.com"
//    )->send(
//        new \App\Mail\SendMessage(
//            $request->name,
//            $request->last_name,
//            $request->email,
//            $request->message));
    return response()->json("success", 200);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
