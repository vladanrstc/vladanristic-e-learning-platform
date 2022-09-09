<?php

namespace App\Modules\Auth\Services;

use App\Models\User;
use App\Modules\Auth\Exceptions\UserAlreadyExistsException;
use App\Modules\Auth\Mails\VerifyMail;
use App\Repositories\IUsersRepo;
use App\Repositories\UsersRepo;
use Exception;
use Illuminate\Support\Facades\Mail;

class RegisterServiceImpl implements IRegisterService
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
     * @throws Exception
     */
    public function registerUser(array $registerParams): User
    {

        if(is_null($this->usersRepo->getUserByEmail($registerParams['email']))) {
            throw new UserAlreadyExistsException($registerParams['email']);
        }

        $user = $this->usersRepo->createUser($registerParams);

        // TODO Change to SendGrid API implementation
//        Mail::to($user->email)->send(new VerifyMail($user));

        return $user;

    }

}
