<?php

namespace App\Modules\Auth\Controllers;

use App\Enums\Modules;
use App\Exceptions\UserUpdateFailedException;
use App\Http\Controllers\Controller;
use App\Lang\ILangHelper;
use App\Modules\Auth\Exceptions\UserAlreadyExistsException;
use App\Modules\Auth\Requests\RegisterRequest;
use App\Modules\Auth\Services\IRegisterService;
use App\Modules\Auth\Services\RegisterServiceImpl;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class RegisterController extends Controller
{

    /**
     * @var IRegisterService
     */
    private IRegisterService $registerService;

    /**
     * @var ILangHelper
     */
    private ILangHelper $langHelper;

    /**
     * @param  RegisterServiceImpl  $registerService
     * @param  ILangHelper  $langHelper
     */
    public function __construct(RegisterServiceImpl $registerService, ILangHelper $langHelper)
    {
        $this->registerService = $registerService;
        $this->langHelper      = $langHelper;
    }

    /**
     * @param  RegisterRequest  $registerRequest
     * @return JsonResponse
     */
    public function register(RegisterRequest $registerRequest): JsonResponse
    {
        try {
            return response()->json(["data" => $this->registerService->registerUser($registerRequest->all())]);
        } catch (UserAlreadyExistsException $userAlreadyExistsException) {
            return response()->json(["message" => $userAlreadyExistsException->getMessage()], 422);
        } catch (Exception $exception) {
            return response()->json(["message" => $exception->getMessage()], 500);
        }
    }

    /**
     * @param  string  $token
     * @return Application|JsonResponse|RedirectResponse|Redirector
     * @throws UserUpdateFailedException
     */
    public function verify(string $token): JsonResponse|Redirector|Application|RedirectResponse
    {
        return ($this->registerService->verify($token)) ?
            redirect(env("APP_FRONTEND_URL") . "/" . $token . "/confirmed") :
            response()->json(
                ["message" => $this->langHelper->getMessage("email_verification_failed", Modules::AUTH)],
                500
            );
    }

}
