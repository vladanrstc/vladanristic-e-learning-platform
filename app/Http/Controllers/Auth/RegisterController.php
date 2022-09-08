<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{

    public function register(Request $user) {

        request()->validate([
            'name' => 'required|max:255|min:3',
            'last_name' => 'required|max:255|min:3',
            'email' => 'required|email|max:255|min:3',
            'password' => 'required|max:255|min:3',
            'language' => 'required|max:255|min:2',
        ]);

        $check_user_exists = User::where("email", "like", $user->email)->first();
        if($check_user_exists != null) {
            return response()->json("user already exists", 401);
        }

        $created_user = new User();
        $created_user->password = $user->password;
        $created_user->email = $user->email;
        $created_user->name = $user->name;
        $created_user->last_name = $user->last_name;
        $created_user->role = "user";
        $created_user->remember_token = Str::random(50);
        $created_user->language = $user->language;
        $created_user->save();
        Mail::to($created_user->email)->send(new VerifyMail($created_user));
        return response()->json($user->email, 200);
    }

    public function verify($token) {

        $user = User::where("remember_token", $token)->whereNull("email_verified_at")->first();

        if($user != null) {
            $user->email_verified_at = new \DateTime();
            $user->save();
            return redirect(url("/" . $token . "/confirmed"));
        }

        return "Non existing user!";

    }

}
