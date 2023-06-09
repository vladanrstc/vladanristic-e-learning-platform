<?php

namespace App\Modules\Auth\Services;

use App\Enums\Modules;
use App\Enums\Roles;
use App\Exceptions\UserUpdateFailedException;
use App\Lang\ILangHelper;
use App\Mails\Builders\IMailDTOBuilder;
use App\Mails\Exceptions\MailNotSentException;
use App\Mails\IMailHandler;
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
    private IUsersRepo $usersRepo;

    /**
     * @var IMailDTOBuilder
     */
    private IMailDTOBuilder $mailDTOBuilder;

    /**
     * @var IMailHandler
     */
    private IMailHandler $mailHandler;

    /**
     * @var ILangHelper
     */
    private ILangHelper $langHelper;

    /**
     * @param  UsersRepo  $usersRepo
     * @param  IMailDTOBuilder  $mailDTOBuilder
     * @param  IMailHandler  $mailHandler
     * @param  ILangHelper  $langHelper
     */
    public function __construct(
        UsersRepo $usersRepo,
        IMailDTOBuilder $mailDTOBuilder,
        IMailHandler $mailHandler,
        ILangHelper $langHelper
    ) {
        $this->usersRepo      = $usersRepo;
        $this->mailDTOBuilder = $mailDTOBuilder;
        $this->mailHandler    = $mailHandler;
        $this->langHelper     = $langHelper;
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
                    ->addSubject($this->langHelper->getMessage("verify_email", Modules::AUTH))
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

        if (!is_null($user = $this->usersRepo->getNonVerifiedUserByToken($token))) {
            $this->usersRepo->updateUser([
                User::emailVerifiedAt() => new \DateTime(),
                User::rememberToken()   => null
            ], $user);

            return true;
        }

        return false;
    }

}
