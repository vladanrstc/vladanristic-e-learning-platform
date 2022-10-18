<?php

namespace App\Modules\Auth\Services;

use App\Enums\Modules;
use App\Enums\Roles;
use App\Exceptions\UserUpdateFailedException;
use App\Lang\LangHelper;
use App\Mails\Builders\MailDTOBuilder;
use App\Mails\Exceptions\MailNotSentException;
use App\Mails\IMailHandler;
use App\Mails\MailHandler;
use App\Models\User;
use App\Modules\Auth\Enums\Messages;
use App\Modules\Auth\Exceptions\UserAlreadyExistsException;
use App\Repositories\IUsersRepo;
use App\Repositories\UsersRepo;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterServiceImpl implements IRegisterService
{

    /**
     * @var IUsersRepo
     */
    private $usersRepo;

    /**
     * @var MailDTOBuilder
     */
    private $mailDTOBuilder;

    /**
     * @var IMailHandler
     */
    private IMailHandler $mailHandler;

    /**
     * @param  UsersRepo  $usersRepo
     */
    public function __construct(UsersRepo $usersRepo, MailDTOBuilder $mailDTOBuilder, IMailHandler $mailHandler)
    {
        $this->usersRepo      = $usersRepo;
        $this->mailDTOBuilder = $mailDTOBuilder;
        $this->mailHandler    = $mailHandler;
    }

    /**
     * @throws Exception
     */
    public function registerUser(array $registerParams): User
    {

        return DB::transaction(function () use ($registerParams) {

            if (!is_null($this->usersRepo->getUserByEmail($registerParams['email']))) {
                throw new UserAlreadyExistsException($registerParams['email']);
            }

            $registerParams['password'] = bcrypt($registerParams['password']);

            $user = $this->usersRepo->createUser(
                $registerParams['name'],
                $registerParams['last_name'],
                $registerParams['email'],
                $registerParams['password'],
                $registerParams['language'],
                Roles::USER->value,
                Str::random(50)
            );

            if (!$this->mailHandler->sendMail(
                $this->mailDTOBuilder
                    ->addTo($user->email)
                    ->addBody(view("emails.verifyUser", ["user" => $user])->render())
                    ->addSubject(LangHelper::getMessage("verify_email", Modules::AUTH))
                    ->build())) {
                throw new MailNotSentException(
                    str_replace(
                        "#{email}", $user->email,
                        Messages::VERIFY_EMAIL_NOT_SENT->value));
            }

            return $user;

        });

    }

    /**
     * @param  string  $token
     * @return bool
     * @throws UserUpdateFailedException
     */
    public function verify(string $token): bool
    {

        $user = $this->usersRepo->getNonVerifiedUserByToken($token);

        if (!is_null($user)) {
            $this->usersRepo->updateUser([
                User::emailVerifiedAt() => new \DateTime(),
                User::rememberToken()   => null
            ], $user);

            return true;
        }

        return false;
    }

}
