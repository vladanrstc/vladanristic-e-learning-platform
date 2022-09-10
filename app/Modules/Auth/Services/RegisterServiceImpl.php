<?php

namespace App\Modules\Auth\Services;

use App\Mails\Builders\MailDTOBuilder;
use App\Mails\Exceptions\MailNotSentException;
use App\Mails\MailHandler;
use App\Models\User;
use App\Modules\Auth\Enums\Messages;
use App\Modules\Auth\Exceptions\UserAlreadyExistsException;
use App\Modules\Auth\Mails\VerifyMail;
use App\Repositories\IUsersRepo;
use App\Repositories\UsersRepo;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
     * @param UsersRepo $usersRepo
     */
    public function __construct(UsersRepo $usersRepo, MailDTOBuilder $mailDTOBuilder) {
        $this->usersRepo      = $usersRepo;
        $this->mailDTOBuilder = $mailDTOBuilder;
    }

    /**
     * @throws Exception
     */
    public function registerUser(array $registerParams): User
    {

        return DB::transaction(function () use($registerParams) {

            if(!is_null($this->usersRepo->getUserByEmail($registerParams['email']))) {
                throw new UserAlreadyExistsException($registerParams['email']);
            }

            $user = $this->usersRepo->createUser($registerParams);

            if(!MailHandler::sendMail($this->mailDTOBuilder
                ->addTo($user->email)
                ->addBody(view("emails.verifyUser", ["user" => $user])->render())
                ->addSubject(Messages::VERIFY_EMAIL->value)
                ->build())) {
                throw new MailNotSentException(str_replace("#{email}", $user->email, Messages::VERIFY_EMAIL_NOT_SENT->value));
            }

            return $user;

        });

    }

}
