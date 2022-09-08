<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

//    use SendsPasswordResetEmails;

    public function send_reset_mail(Request $request) {

        $user = User::where("email", "like", $request->email)->first();

        if($user != null) {
            $pom = Str::random(40);
            $user->remember_token = $pom;
            $user->save();
            Mail::to($user->email)->send(new ResetPassword($user));
        }

        return response()->json("data", 200);
    }

    public function show_form(Request $request, $token) {
        $user = User::where("remember_token", "like", $request->token)->first();
        if($user != null) {
            return view("auth.passwords.reset", ["token" => $token, "lang" => $user->language]);
        } else {
            abort(404);
        }

    }

    public function update_password(Request $request) {

        request()->validate([
            'password' => 'required|max:255|min:3',
            'password_confirmation' => 'required|max:255|min:3|same:password',
        ]);

        $user = User::where("remember_token", "like", $request->token)->first();
        $user->password = $request->password;
        $user->remember_token = null;
        $user->save();

        return view("auth.passwords.reset_success", ["lang" => $user->language]);

    }

}
