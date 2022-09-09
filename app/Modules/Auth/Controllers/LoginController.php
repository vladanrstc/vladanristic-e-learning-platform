<?php

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Auth\Requests\LoginRequest;
use App\Modules\Auth\Services\ILoginService;
use App\Modules\Auth\Services\LoginService;
use App\Repositories\IUsersRepo;
use App\Repositories\UsersRepo;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /**
     * @var ILoginService
     */
    private $loginService;

    public function __construct(LoginService $loginService) {
        $this->loginService = $loginService;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request) {

        $loginResult = $this->loginService->login($request->only(["email", "password"]));

        if(!$loginResult) {
            return response()->json(['message' => 'Your credentials are incorrect. Please try again'], 422);
        }

        return response()->json([
            'ac_t'      => $loginResult['token'],
            'rf_t'      => $loginResult['token'],
            'name'      => $loginResult['user']->name,
            'last_name' => $loginResult['user']->last_name,
            'language'  => $loginResult['user']->language,
            'scopes'    => $loginResult['role']
        ]);

    }

}
