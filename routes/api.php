<?php

//use App\Mail\ResetPassword;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\LessonCompletedController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\TestController;
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

//Route::group(['middleware' => ['auth:api']], function () {

    // course details

//    Route::group(['middleware' => ['scope:user,admin,super-admin']], function () {

        Route::get("/check-admin", function () {
            return response()->json("success", 200);
        });

//        Route::get("/logged/user", [UserController::class, "logged_user"]);
//        Route::patch("/logged/user", [UserController::class, "edit_logged_user"]);



        // notes



        // lessons
        Route::get("/lesson/finish/{lesson}", [LessonCompletedController::class, "finish_lesson"]);

        // tests
        Route::get("/test/data/{lesson}", [TestController::class, "get_test_data"]);
        Route::post("/test/submit/{test}", [TestController::class, "submit_test"]);

//    });

//    Route::group(['middleware' => ['scope:admin,super-admin']], function () {


        Route::resource('sections', SectionController::class);

        Route::resource('lessons', LessonController::class);
        Route::post("/lessons/update/{lesson}", [LessonController::class, "update"]);

        Route::resource('tests', TestController::class);
        Route::resource('answers', AnswerController::class);
        Route::resource('questions', QuestionController::class);


        Route::get("/questions/test/{test}", [QuestionController::class, "test_questions"]);
        Route::get("/test/status/{test}", [TestController::class, "test_requirements"]);

        Route::get("/lessons/section/{section}", [LessonController::class, "section_lessons"]);
        Route::post("/lessons/order", [LessonController::class, "lessons_order"]);
        Route::post("/lessons/switch", [LessonController::class, "lessons_switch"]);
        Route::post("/lessons/video", [LessonController::class, "lessons_video"]);

        Route::get("/sections/course/{course}", [SectionController::class, "course_sections"]);
        Route::post("/sections/order", [SectionController::class, "sections_order"]);

//    });



//});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
