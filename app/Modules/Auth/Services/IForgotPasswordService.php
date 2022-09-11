<?php

namespace App\Modules\Auth\Services;

interface IForgotPasswordService {
    public function sendResetPasswordMail(string $email): bool;
}
