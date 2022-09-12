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
     * @param string $name
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @param string $language
     * @return User
     */
    public function createUser(string $name, string $lastName, string $email, string $password, string $language): User {
        $created_user = new User();
        $created_user->{User::name()}          = $name;
        $created_user->{User::lastName()}      = $lastName;
        $created_user->{User::email()}         = $email;
        $created_user->{User::password()}      = $password;
        $created_user->{User::role()}          = Roles::USER->value;
        $created_user->{User::rememberToken()} = Str::random(50);
        $created_user->{User::language()}      = $language;
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
        if($user->update($paramsToUpdate)) {
            return $user;
        }
        throw new UserUpdateFailedException();
    }

}
