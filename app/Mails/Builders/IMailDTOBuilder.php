<?php

namespace App\Mails\Builders;

use App\Mails\MailDTOs\MailDataDTO;

interface IMailDTOBuilder
{
    public function addSubject(string $subject): static;

    public function addBody(string $content): static;

    public function addTo(string $toEmail): static;

    public function addCC(string $ccEmail): static;

    public function addBCC(string $bccEmail): static;

    public function build(): MailDataDTO;
}
