<?php

namespace App\Mails;

use App\Mails\Exceptions\MailHandlerSingletonException;
use App\Mails\MailDTOs\MailDataDTO;
use Exception;
use Illuminate\Support\Facades\Log;
use SendGrid\Mail\Mail;
use SendGrid\Mail\TypeException;

class MailHandler implements IMailHandler
{

    /**
     * @var int
     */
    private static int $numOfInstances = 0;

    /**
     * @throws MailHandlerSingletonException
     */
    public function __construct()
    {
        self::$numOfInstances === 0 ? self::$numOfInstances++ : throw new MailHandlerSingletonException();
    }

    /**
     * @param  MailDataDTO  $mailDataDTO
     * @return bool
     * @throws TypeException
     */
    public function sendMail(MailDataDTO $mailDataDTO): bool
    {

        $email = new Mail();
        $email->setFrom(env("MAIL_FROM_ADDRESS"), env("MAIL_FROM_NAME"));
        $email->setSubject($mailDataDTO->getSubject());
        foreach ($mailDataDTO->getTo() as $toEmailAddress) {
            $email->addTo($toEmailAddress);
        }

        $email->addContent("text/html", $mailDataDTO->getBody());

        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $res = $sendgrid->send($email);
            if ($res->statusCode() == 202) {
                return true;
            }
            Log::error($res->body());
            return false;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }

    }

}
