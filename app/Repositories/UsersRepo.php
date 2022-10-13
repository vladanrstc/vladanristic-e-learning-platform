<?php

namespace App\Repositories;

use App\Exceptions\BanUserException;
use App\Exceptions\UserPermanentDeleteException;
use App\Exceptions\UserUpdateFailedException;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Log;

class UsersRepo implements IUsersRepo
{

    /**
     * @param  string  $email
     * @return User|null
     */
    public function getUserByEmail(string $email): User|null
    {
        return User::where('email', $email)->first();
    }

    /**
     * @param  string  $name
     * @param  string  $lastName
     * @param  string  $email
     * @param  string  $password
     * @param  string  $language
     * @param  string  $role
     * @param  string|null  $rememberToken
     * @param  DateTime|null  $emailVerifiedAt
     * @return User
     */
    public function createUser(
        string $name,
        string $lastName,
        string $email,
        string $password,
        string $language,
        string $role,
        string $rememberToken = null,
        DateTime $emailVerifiedAt = null
    ): User {
        $created_user                            = new User();
        $created_user->{User::name()}            = $name;
        $created_user->{User::lastName()}        = $lastName;
        $created_user->{User::email()}           = $email;
        $created_user->{User::password()}        = $password;
        $created_user->{User::role()}            = $role;
        $created_user->{User::rememberToken()}   = $rememberToken;
        $created_user->{User::language()}        = $language;
        $created_user->{User::emailVerifiedAt()} = $emailVerifiedAt;
        $created_user->save();
        return $created_user;
    }

    /**
     * @param  string  $token
     * @return User|null
     */
    public function getNonVerifiedUserByToken(string $token): User|null
    {
        return User::where(User::rememberToken(), $token)
            ->whereNull(User::emailVerifiedAt())
            ->first();
    }

    /**
     * @param  array  $paramsToUpdate
     * @param  User  $user
     * @return User
     * @throws UserUpdateFailedException
     */
    public function updateUser(array $paramsToUpdate, User $user): User
    {
        if ($user->update($paramsToUpdate)) {
            return $user;
        }
        throw new UserUpdateFailedException();
    }

    /**
     * @param  User  $user
     * @return bool
     * @throws UserPermanentDeleteException
     */
    public function permanentlyDeleteUser(User $user): bool
    {
        if ($user->forceDelete()) {
            return true;
        }
        throw new UserPermanentDeleteException();
    }

    /**
     * @param  User  $user
     * @return bool
     * @throws BanUserException
     */
    public function banUser(User $user): bool
    {
        if ($user->delete()) {
            return true;
        }
        throw new BanUserException();
    }

    /**
     * @param  int  $userId
     * @return User
     */
    public function getTrashedUserById(int $userId): User
    {
        return User::where("id", $userId)->onlyTrashed()
            ->first();
    }

    /**
     * @param  int  $id
     * @return User|null
     */
    public function getUserById(int $id): User|null
    {
        return User::where("id", $id)->first();
    }

    /**
     * @param  User  $bannedUser
     * @return mixed
     */
    public function unbanUser(User $bannedUser): bool
    {
        return $bannedUser->restore();
    }

    /**
     * @param  string  $token
     * @return User|null
     */
    public function getUserByToken(string $token): User|null
    {
        return User::where(User::rememberToken(), $token)->first();
    }
}
