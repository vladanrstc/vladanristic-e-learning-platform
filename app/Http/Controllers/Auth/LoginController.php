<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
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
            $response = $http->post(\config('api_credentials.PASSPORT_APP_IP'). '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => '2',
                    'client_secret' => \config('api_credentials.PASSPORT_CLIENT_SECRET'),
                    'username' => $request->email,
                    'password' => $request->password,
                    'scope' => $role
                ],
            ]);
            $pom = json_decode((string) $response->getBody(), true);
            return response()->json([
                'ac_t' => $pom['access_token'],
                'rf_t' => $pom['refresh_token'],
                'name' => $user->name,
                'last_name' => $user->last_name,
                'language' => $user->language], 200);

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
