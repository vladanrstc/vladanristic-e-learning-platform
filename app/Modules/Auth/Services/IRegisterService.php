<?php

namespace App\Modules\Auth\Services;

use App\Models\User;

interface IRegisterService {
    public function registerUser(array $registerParams): User;
    public function verify(string $token): bool;
}
