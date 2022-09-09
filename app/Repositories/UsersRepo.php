<?php

namespace App\Repositories;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Support\Str;

class UsersRepo implements IUsersRepo {

    /**
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email): User|null {
        return User::where('email', $email)->first();
    }

    public function createUser(array $userData): User {
        $created_user = new User();
        $created_user->password       = $userData['password'];
        $created_user->email          = $userData['email'];
        $created_user->name           = $userData['name'];
        $created_user->last_name      = $userData['last_name'];
        $created_user->role           = Roles::USER;
        $created_user->remember_token = Str::random(50);
        $created_user->language       = $userData['language'];
        $created_user->save();
        return $created_user;
    }

}
