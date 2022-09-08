<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function login(Request $request) {
        $http = new \GuzzleHttp\Client;
        $user = User::where('email', $request->email)->first();

        if($user != null) {

            if(!Hash::check($request->password, $user->password)) {
                return response()->json('Your credentials are incorrect. Please try again', 401);
            }

            if($user->email_verified_at == null) {
                return response()->json(["flag" => false], 200);
            }

        } else {
            return response()->json('Your credentials are incorrect. Please try again', 401);
        }

        $role = $user->role;

        try {

            // Creating a token with scopes...
            $token = $user->createToken('My Token', [$role])->plainTextToken;

            return response()->json([
                'ac_t' => $token,
                'rf_t' => $token,
                'name' => $user->name,
                'last_name' => $user->last_name,
                'language' => $user->language,
                'scopes'   => $role
            ]);

        } catch (\GuzzleHttp\Exception\BadResponseException $e) {

            if ($e->getCode() === 400) {
                return response()->json('Invalid Request. Please enter a username or a password.', $e->getCode());
            } else if ($e->getCode() === 401) {
                return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
            }
            return $e->getMessage();
            return response()->json('Something went wrong on the server.', $e->getCode());

        }
    }

}
