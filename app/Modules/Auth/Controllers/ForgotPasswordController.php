<?php

namespace App\Modules\Auth\Controllers;

use App\Enums\Modules;
use App\Http\Controllers\Controller;
use App\Lang\LangHelper;
use App\Modules\Auth\Requests\PasswordResetRequest;
use App\Modules\Auth\Services\ForgotPasswordService;
use App\Modules\Auth\Services\IForgotPasswordService;
use Exception;
use Illuminate\Http\JsonResponse;

class ForgotPasswordController extends Controller
{

    /**
     * @var IForgotPasswordService
     */
    private IForgotPasswordService $forgotPasswordService;

    public function __construct(ForgotPasswordService $forgotPasswordService) {
        $this->forgotPasswordService = $forgotPasswordService;
    }

    /**
     * @param PasswordResetRequest $request
     * @return JsonResponse
     */
    public function sendResetMail(PasswordResetRequest $request): JsonResponse
    {

        try {
            if($this->forgotPasswordService->sendResetPasswordMail($request->get("email"))) {
                return response()->json(["data" => LangHelper::getMessage("reset_password_email_sent", Modules::AUTH)]);
            }
            return response()->json(["data" => LangHelper::getMessage("reset_password_email_sent", Modules::AUTH)]);
        } catch (Exception $exception) {
            return response()->json(["data" => $exception->getMessage()]);
        }

    }

    // TODO: Complete show form and update password
    /*
    public function show_form(Request $request, $token) {
        $user = User::where("remember_token", "like", $request->token)->first();
        if($user != null) {
            return view("auth.passwords.reset", ["token" => $token, "lang" => $user->language]);
        } else {
            abort(404);
        }

    }

    public function update_password(Request $request) {

        request()->validate([
            'password' => 'required|max:255|min:3',
            'password_confirmation' => 'required|max:255|min:3|same:password',
        ]);

        $user = User::where("remember_token", "like", $request->token)->first();
        $user->password = $request->password;
        $user->remember_token = null;
        $user->save();

        return view("auth.passwords.reset_success", ["lang" => $user->language]);

    }
    */
}
