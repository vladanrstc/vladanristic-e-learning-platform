<?php

namespace App\Modules\Auth\Services;

use App\Repositories\IUsersRepo;
use App\Repositories\UsersRepo;
use Illuminate\Support\Facades\Auth;

class LoginServiceImpl implements ILoginService
{

    /**
     * @var IUsersRepo
     */
    private $usersRepo;

    /**
     * @param UsersRepo $usersRepo
     */
    public function __construct(UsersRepo $usersRepo) {
        $this->usersRepo = $usersRepo;
    }

    /**
     * @param $loginParams
     * @return bool|array
     */
    public function login(array $loginParams): bool|array {

        if(Auth::attempt($loginParams)) {
            // Creating a token with scopes
            $user  = $this->usersRepo->getUserByEmail($loginParams['email']);
            $role  = $user->role;

            $token = $user->createToken('My Token', [$role])->plainTextToken;

            return [
                "user"  => $user,
                "token" => $token,
                "role"  => $role
            ];
        }

        return false;

    }

}
