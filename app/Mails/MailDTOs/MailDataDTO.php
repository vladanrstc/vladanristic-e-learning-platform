<?php

namespace App\Mails\MailDTOs;

class MailDataDTO
{

    private string $subject = "";
    private string $body = "";
    private array $to = [];
    private array $cc = [];
    private array $bcc = [];

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param  string  $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param  string  $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return array
     */
    public function getTo(): array
    {
        return $this->to;
    }

    /**
     * @param  array  $to
     */
    public function setTo(array $to): void
    {
        $this->to = $to;
    }

    /**
     * @return array
     */
    public function getCc(): array
    {
        return $this->cc;
    }

    /**
     * @param  array  $cc
     */
    public function setCc(array $cc): void
    {
        $this->cc = $cc;
    }

    /**
     * @return array
     */
    public function getBcc(): array
    {
        return $this->bcc;
    }

    /**
     * @param  array  $bcc
     */
    public function setBcc(array $bcc): void
    {
        $this->bcc = $bcc;
    }

    /**
     * @param  string  $toEmail
     */
    public function addTo(string $toEmail)
    {
        $this->to[] = $toEmail;
    }

    /**
     * @param  string  $ccEmail
     */
    public function addCC(string $ccEmail)
    {
        $this->to[] = $ccEmail;
    }

    /**
     * @param  string  $bccEmail
     */
    public function addBCC(string $bccEmail)
    {
        $this->to[] = $bccEmail;
    }

}
