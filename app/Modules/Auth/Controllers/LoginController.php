<?php

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Auth\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request) {

            if(Auth::attempt($request->only(["email", "password"]))) {

                // Creating a token with scopes
                $user  = User::where('email', $request->email)->first();
                $role  = $user->role;

                $token = $user->createToken('My Token', [$role])->plainTextToken;

                return response()->json([
                    'ac_t'      => $token,
                    'rf_t'      => $token,
                    'name'      => $user->name,
                    'last_name' => $user->last_name,
                    'language'  => $user->language,
                    'scopes'    => $role
                ]);

            }

            return response()->json(['message' => 'Your credentials are incorrect. Please try again'], 422);

    }

}
