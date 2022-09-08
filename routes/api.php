<?php

//use App\Mail\ResetPassword;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseStartController;
use App\Http\Controllers\LessonCompletedController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Modules\Auth\Controllers\LoginController;
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

// get last three videos
Route::get("/home/videos", "HomeController@last_three_videos");

// register and login routes
Route::post('/login', [LoginController::class, "login"]);
Route::post('/register', [RegisterController::class, "register"]);

Route::get("/courses/all", [CourseController::class, "all_courses"]);

Route::post("/reset-password", [ForgotPasswordController::class, "send_reset_mail"]);

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

Route::group(['middleware' => ['auth:api']], function () {

    // course details
    Route::get("/course/details/{course}", [CourseController::class, "course_details"]);

    Route::group(['middleware' => ['scope:user,admin,super-admin']], function () {

        Route::get("/check-admin", function () {
            return response()->json("success", 200);
        });

        Route::get("/logged/user", [UserController::class, "logged_user"]);
        Route::patch("/logged/user", [UserController::class, "edit_logged_user"]);

        Route::resource('user_courses_started', CourseStartController::class);

        // started and not started courses
        Route::get("/courses/started", [CourseStartController::class, "courses_started"]);
        Route::get("/courses/not-started", [CourseStartController::class, "courses_not_started"]);

        // notes
        Route::patch("/courses/started/notes", [NoteController::class, "update_course_note"]);
        Route::get("/courses/started/notes/{course}", [NoteController::class, "get_course_note"]);

        // reviews
        Route::patch("/courses/started/review", [ReviewController::class, "update_course_review"]);
        Route::get("/courses/started/review/{course}", [ReviewController::class, "get_course_review"]);
        Route::get("/reviews/course/user/{course}", [ReviewController::class, "course_reviews_user"]);

        // lessons
        Route::get("/lesson/finish/{lesson}", [LessonCompletedController::class, "finish_lesson"]);

        // tests
        Route::get("/test/data/{lesson}", [TestController::class, "get_test_data"]);
        Route::post("/test/submit/{test}", [TestController::class, "submit_test"]);

    });

    Route::group(['middleware' => ['scope:admin,super-admin']], function () {

        Route::get("/stats", [StatsController::class, "general_stats"]);

        Route::resource('courses', CourseController::class);
        Route::post("/courses/update/{course}", [CourseController::class, "update"]);

        Route::resource('sections', SectionController::class);

        Route::resource('lessons', LessonController::class);
        Route::post("/lessons/update/{lesson}", [LessonController::class, "update"]);

        Route::resource('tests', TestController::class);
        Route::resource('answers', AnswerController::class);
        Route::resource('questions', QuestionController::class);
        Route::resource('reviews', ReviewController::class);
        Route::resource('notes', NoteController::class);

        Route::get("/reviews/course/{course}", [ReviewController::class, "course_reviews"]);
        Route::get("/notes/course/{course}", [NoteController::class, "course_notes"]);

        Route::get("/questions/test/{test}", [QuestionController::class, "test_questions"]);
        Route::get("/test/status/{test}", [TestController::class, "test_requirements"]);

        Route::get("/lessons/section/{section}", [LessonController::class, "section_lessons"]);
        Route::post("/lessons/order", [LessonController::class, "lessons_order"]);
        Route::post("/lessons/switch", [LessonController::class, "lessons_switch"]);
        Route::post("/lessons/video", [LessonController::class, "lessons_video"]);

        Route::get("/sections/course/{course}", [SectionController::class, "course_sections"]);
        Route::post("/sections/order", [SectionController::class, "sections_order"]);

    });

    Route::group(['middleware' => ['scope:super-admin']], function () {
        Route::resource('users', "UserController");
        Route::delete("/users/ban/{user}", [UserController::class, "ban_user"]);
        Route::get("/users-banned", [UserController::class, "banned_users"]);
        Route::get("/users/unban/{user}", [UserController::class, "unban_user"]);
    });

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
