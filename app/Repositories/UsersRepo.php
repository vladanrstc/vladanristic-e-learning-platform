<?php

namespace App\Repositories;

use App\Models\User;

class UsersRepo implements IUsersRepo {

    /**
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email): User|null {
        return User::where('email', $email)->first();
    }

}
