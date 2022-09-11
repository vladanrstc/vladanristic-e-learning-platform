<?php

namespace App\Modules\Auth\Controllers;

use App\Enums\Modules;
use App\Exceptions\MessageTranslationNotFoundException;
use App\Exceptions\UserUpdateFailedException;
use App\Http\Controllers\Controller;
use App\Lang\LangHelper;
use App\Modules\Auth\Exceptions\CourseNotFoundException;
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
    private $registerService;

    /**
     * @param RegisterServiceImpl $registerService
     */
    public function __construct(RegisterServiceImpl $registerService) {
        $this->registerService = $registerService;
    }

    /**
     * @param RegisterRequest $registerRequest
     * @return JsonResponse
     */
    public function register(RegisterRequest $registerRequest) {
        try {
            return response()->json(["data" => $this->registerService->registerUser($registerRequest->all())]);
        } catch (CourseNotFoundException $userAlreadyExistsException) {
            return response()->json(["message" => $userAlreadyExistsException->getMessage()], 422);
        } catch (Exception $exception) {
            return response()->json(["message" => $exception->getMessage()], 500);
        }
    }

    /**
     * @param string $token
     * @return Application|JsonResponse|RedirectResponse|Redirector
     * @throws UserUpdateFailedException|MessageTranslationNotFoundException
     */
    public function verify(string $token) {
        if($this->registerService->verify($token)) {
            return redirect(url("/" . $token . "/confirmed"));
        }
        return response()->json(["message" => LangHelper::getMessage("email_verification_failed", Modules::AUTH)], 500);
    }

}
