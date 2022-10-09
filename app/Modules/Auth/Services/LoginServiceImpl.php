<?php

namespace App\Modules\Auth\Services;

use App\Enums\LogTypes;
use App\Models\Log;
use App\Models\User;
use App\Repositories\ILogsRepo;
use App\Repositories\IUsersRepo;
use App\Repositories\UsersRepo;
use Illuminate\Support\Facades\Auth;

class LoginServiceImpl implements ILoginService
{

    /**
     * @var IUsersRepo
     */
    private IUsersRepo $usersRepo;

    /**
     * @var ILogsRepo
     */
    private ILogsRepo $logsRepo;

    /**
     * @param UsersRepo $usersRepo
     * @param ILogsRepo $logsRepo
     */
    public function __construct(IUsersRepo $usersRepo, ILogsRepo $logsRepo) {
        $this->usersRepo = $usersRepo;
        $this->logsRepo  = $logsRepo;
    }

    /**
     * @param array $loginParams
     * @return bool|array
     */
    public function login(array $loginParams): bool|array {

        if(Auth::attempt($loginParams)) {
            // Creating a token with scopes
            $user  = $this->usersRepo->getUserByEmail($loginParams['email']);
            $role  = $user->{User::role()};

            $token = $user->createToken('My Token', [strtolower($role)])->accessToken;

            $this->logsRepo->insertLog([
                Log::logType() => LogTypes::USER_LOGGED_IN->value
            ]);

            return [
                "user"  => $user,
                "token" => $token,
                "role"  => $role
            ];
        }

        return false;

    }

}
