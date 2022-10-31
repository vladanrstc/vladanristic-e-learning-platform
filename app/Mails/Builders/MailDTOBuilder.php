<?php

namespace App\Mails\Builders;

use App\Mails\MailDTOs\MailDataDTO;

class MailDTOBuilder implements IMailDTOBuilder
{

    /**
     * @var MailDataDTO
     */
    private MailDataDTO $mailDataDTO;

    public function __construct()
    {
        $this->mailDataDTO = new MailDataDTO();
    }

    /**
     * @param  string  $subject
     * @return $this
     */
    public function addSubject(string $subject): static
    {
        $this->mailDataDTO->setSubject($subject);
        return $this;
    }

    /**
     * @param  string  $content
     * @return $this
     */
    public function addBody(string $content): static
    {
        $this->mailDataDTO->setBody($content);
        return $this;
    }

    /**
     * @param  string  $toEmail
     * @return $this
     */
    public function addTo(string $toEmail): static
    {
        $this->mailDataDTO->addTo($toEmail);
        return $this;
    }

    /**
     * @param  string  $ccEmail
     * @return $this
     */
    public function addCC(string $ccEmail): static
    {
        $this->mailDataDTO->addCC($ccEmail);
        return $this;
    }

    /**
     * @param  string  $bccEmail
     * @return $this
     */
    public function addBCC(string $bccEmail): static
    {
        $this->mailDataDTO->addTo($bccEmail);
        return $this;
    }

    /**
     * @return MailDataDTO
     */
    public function build(): MailDataDTO
    {
        return $this->mailDataDTO;
    }

}
