<?php

//use App\Mail\ResetPassword;
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
    Mail::to("vladanrstc@gmail.com"
    )->send(new \App\Mail\SendMessage(
        $request->name,
        $request->last_name,
        $request->email,
        $request->message));
    return response()->json("success", 200);
});

Route::post("/get-new-token", function (Request $request) {

    $http = new \GuzzleHttp\Client;
    try {
        $response = $http->post(\config('api_credentials.PASSPORT_APP_IP'). '/oauth/token', [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => $request->rf_t,
                'client_id' => '2',
                'client_secret' => \config('api_credentials.PASSPORT_CLIENT_SECRET'),
                'scope' => ''
            ],
        ]);
        $pom = json_decode((string) $response->getBody(), true);
        \Illuminate\Support\Facades\Log::info($pom);
        return response()->json([
            'ac_t' => $pom['access_token'],
            'rf_t' => $pom['refresh_token'],
        ], 200);

    } catch (\GuzzleHttp\Exception\BadResponseException $e) {

        if ($e->getCode() === 400) {
            return response()->json('Invalid Request. Please enter a username or a password.', $e->getCode());
        } else if ($e->getCode() === 401) {
            return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
        }
        return $e->getMessage();
        return response()->json('Something went wrong on the server.', $e->getCode());

    }

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
