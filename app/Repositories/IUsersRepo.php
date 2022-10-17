<?php

namespace App\Repositories;

use App\Models\User;
use DateTime;

interface IUsersRepo
{
    public function getUserByEmail(string $email): User|null;

    public function getUserById(int $id): User|null;

    public function getNonVerifiedUserByToken(string $token): User|null;

    public function createUser(
        string $name,
        string $lastName,
        string $email,
        string $password,
        string $language,
        string $role,
        string $rememberToken = null,
        DateTime $emailVerifiedAt = null
    ): User;

    public function getTrashedUserById(int $userId): User;

    public function unbanUser(User $bannedUser): bool;

    public function updateUser(array $paramsToUpdate, User $user): User;

    public function permanentlyDeleteUser(User $user): bool;

    public function getUserByToken(string $token): User|null;

    public function banUser(User $user): bool;

    public function getUsersByEmail(string $searchParam);

    public function getUsers();
}
