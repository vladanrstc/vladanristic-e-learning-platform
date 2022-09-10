<?php

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Auth\Exceptions\UserAlreadyExistsException;
use App\Modules\Auth\Requests\RegisterRequest;
use App\Modules\Auth\Services\IRegisterService;
use App\Modules\Auth\Services\RegisterServiceImpl;
use Exception;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{

    /**
     * @var IRegisterService
     */
    private $registerService;

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
        } catch (UserAlreadyExistsException $userAlreadyExistsException) {
            return response()->json(["message" => $userAlreadyExistsException->getMessage()], 422);
        } catch (Exception $exception) {
            return response()->json(["message" => $exception->getMessage()], 500);
        }
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
