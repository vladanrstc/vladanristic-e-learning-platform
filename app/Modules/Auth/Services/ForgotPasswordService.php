<?php

namespace App\Modules\Auth\Services;

use App\Mails\Builders\MailDTOBuilder;
use App\Mails\Exceptions\MailNotSentException;
use App\Mails\MailHandler;
use App\Models\User;
use App\Modules\Auth\Enums\Messages;
use App\Repositories\IUsersRepo;
use App\Repositories\UsersRepo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ForgotPasswordService implements IForgotPasswordService
{

    /**
     * @var IUsersRepo
     */
    private IUsersRepo $usersRepo;

    /**
     * @var MailDTOBuilder
     */
    private MailDTOBuilder $mailDTOBuilder;

    /**
     * @param UsersRepo $usersRepo
     * @param MailDTOBuilder $mailDTOBuilder
     */
    public function __construct(UsersRepo $usersRepo, MailDTOBuilder $mailDTOBuilder) {
        $this->usersRepo      = $usersRepo;
        $this->mailDTOBuilder = $mailDTOBuilder;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function sendResetPasswordMail(string $email): bool
    {

        return DB::transaction(function() use($email) {

            if(!is_null($user = $this->usersRepo->getUserByEmail($email))) {

                $user = $this->usersRepo->updateUser([
                    User::rememberToken() => Str::random(40)
                ], $user);

                if(!MailHandler::sendMail($this->mailDTOBuilder
                    ->addTo($user->email)
                    ->addBody(view("emails.resetPassword", ["user" => $user])->render())
                    ->addSubject(Messages::RESET_PASSWORD_EMAIL_SUBJECT->value)
                    ->build())) {
                    throw new MailNotSentException(Messages::RESET_PASSWORD_EXCEPTION->value);
                }

                return true;

            }

            return false;

        });

    }
}
