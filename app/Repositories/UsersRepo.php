<?php

namespace App\Repositories;

use App\Enums\Roles;
use App\Exceptions\UserUpdateFailedException;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UsersRepo implements IUsersRepo {

    /**
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email): User|null {
        return User::where('email', $email)->first();
    }

    /**
     * @param array $userData
     * @return User
     */
    public function createUser(array $userData): User {
        $created_user = new User();
        $created_user->{User::password()}       = $userData['password'];
        $created_user->{User::email()}          = $userData['email'];
        $created_user->{User::name()}           = $userData['name'];
        $created_user->{User::lastName()}       = $userData['last_name'];
        $created_user->{User::role()}           = Roles::USER;
        $created_user->{User::rememberToken()}  = Str::random(50);
        $created_user->{User::language()}       = $userData['language'];
        $created_user->save();
        return $created_user;
    }

    /**
     * @param string $token
     * @return User|null
     */
    public function getNonVerifiedUserByToken(string $token): User|null
    {
        return User::where(User::rememberToken(), $token)
            ->whereNull(User::emailVerifiedAt())
            ->first();
    }

    /**
     * @param array $paramsToUpdate
     * @param User $user
     * @return User
     * @throws UserUpdateFailedException
     */
    public function updateUser(array $paramsToUpdate, User $user): User {
        Log::info($paramsToUpdate);
        if($user->update($paramsToUpdate)) {
            return $user;
        }
        throw new UserUpdateFailedException();
    }

}
