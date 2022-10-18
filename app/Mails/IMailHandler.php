<?php

namespace App\Mails;

use App\Mails\MailDTOs\MailDataDTO;

interface IMailHandler
{
    public function sendMail(MailDataDTO $mailDataDTO): bool;
}
