<?php

namespace App\Repositories;

use App\Models\User;

interface IUsersRepo {
    public function getUserByEmail(string $email): User|null;
    public function getNonVerifiedUserByToken(string $token): User|null;
    public function createUser(array $userData): User;
}
