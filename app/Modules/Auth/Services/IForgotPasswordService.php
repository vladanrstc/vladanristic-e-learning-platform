<?php

namespace App\Modules\Auth\Services;

use App\Models\User;

interface IForgotPasswordService
{
    public function sendResetPasswordMail(string $email): bool;

    public function updateUserPassword(string $token, string $password): User;

    public function getUserWithToken(string $token): User|null;
}
