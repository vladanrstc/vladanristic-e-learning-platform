<?php

namespace App\Modules\User\Services;

use App\Models\User;

interface IUserService {
    public function createUser(array $userData): User;
    public function updateUser(array $userDataToUpdate, User $user): User;
    public function permanentlyDeleteUser(int $userId): bool;
    public function unbanUser(int $userId): bool;
}
