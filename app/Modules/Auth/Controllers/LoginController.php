<?php

namespace App\Modules\Auth\Controllers;

use App\Enums\Modules;
use App\Exceptions\MessageTranslationNotFoundException;
use App\Http\Controllers\Controller;
use App\Lang\LangHelper;
use App\Modules\Auth\Requests\LoginRequest;
use App\Modules\Auth\Services\ILoginService;
use App\Modules\Auth\Services\LoginServiceImpl;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{

    /**
     * @var ILoginService
     */
    private $loginService;

    public function __construct(LoginServiceImpl $loginService) {
        $this->loginService = $loginService;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws MessageTranslationNotFoundException
     */
    public function login(LoginRequest $request) {

        $loginResult = $this->loginService->login($request->only(["email", "password"]));

        if(!$loginResult) {
            return response()->json(['message' => LangHelper::getMessage("incorrect_credentials", Modules::AUTH)], 422);
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
