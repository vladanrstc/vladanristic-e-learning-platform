<?php

namespace App\Mails\Builders;

use App\Mails\MailDTOs\MailDataDTO;

interface IMailDTOBuilder
{
    public function addSubject(string $subject);

    public function addBody(string $content);

    public function addTo(string $toEmail);

    public function addCC(string $ccEmail);

    public function addBCC(string $bccEmail);

    public function build(): MailDataDTO;
}
