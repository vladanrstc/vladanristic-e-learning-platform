<?php

use App\Mails\Builders\MailDTOBuilder;
use App\Mails\MailHandler;
use App\Mails\Requests\MessageRequest;
use Illuminate\Http\Request;
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

Route::post("/message", function (MessageRequest $request) {

    $mailDtoBuilder = new MailDTOBuilder();

    MailHandler::sendMail(
        $mailDtoBuilder
            ->addSubject("New message from {$request->name} {$request->last_name}")
            ->addBody("From: $request->email . <hr> " . $request->message)
            ->addTo(env("ADMIN_MAIL"))
            ->build()
    );

    return response()->json("success", 200);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
