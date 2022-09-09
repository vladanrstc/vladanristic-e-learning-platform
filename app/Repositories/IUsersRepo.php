<?php

namespace App\Repositories;

use App\Models\User;

interface IUsersRepo {
    public function getUserByEmail(string $email): User|null;
}
