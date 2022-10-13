<?php

namespace App\Modules\Auth\Controllers;

use App\Enums\Modules;
use App\Exceptions\UserUpdateFailedException;
use App\Http\Controllers\Controller;
use App\Lang\LangHelper;
use App\Models\User;
use App\Modules\Auth\Requests\PasswordResetRequest;
use App\Modules\Auth\Requests\UpdatePasswordRequest;
use App\Modules\Auth\Services\ForgotPasswordService;
use App\Modules\Auth\Services\IForgotPasswordService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

class ForgotPasswordController extends Controller
{

    /**
     * @var IForgotPasswordService
     */
    private IForgotPasswordService $forgotPasswordService;

    public function __construct(ForgotPasswordService $forgotPasswordService)
    {
        $this->forgotPasswordService = $forgotPasswordService;
    }

    /**
     * @param  PasswordResetRequest  $request
     * @return JsonResponse
     */
    public function sendResetMail(PasswordResetRequest $request): JsonResponse
    {

        try {
            if ($this->forgotPasswordService->sendResetPasswordMail($request->get("email"))) {
                return response()->json(["data" => LangHelper::getMessage("reset_password_email_sent", Modules::AUTH)]);
            }
            return response()->json(["data" => LangHelper::getMessage("reset_password_email_sent", Modules::AUTH)]);
        } catch (Exception $exception) {
            return response()->json(["data" => $exception->getMessage()]);
        }

    }

    /**
     * @param $token
     * @return Application|Factory|View|void
     */
    public function showForm($token)
    {
        if (!is_null($user = $this->forgotPasswordService->getUserWithToken($token))) {
            return view("auth.passwords.reset", ["token" => $token, "lang" => $user->{User::language()}]);
        } else {
            abort(404);
        }

    }

    /**
     * @param  UpdatePasswordRequest  $request
     * @return Application|Factory|View
     * @throws UserUpdateFailedException
     */
    public function updatePassword(UpdatePasswordRequest $request): View|Factory|Application
    {
        $user = $this->forgotPasswordService->updateUserPassword(
            $request->input("token"),
            $request->input("password")
        );
        return view("auth.passwords.reset_success", [
            "lang" => $user->{User::language()}
        ]);
    }

}
