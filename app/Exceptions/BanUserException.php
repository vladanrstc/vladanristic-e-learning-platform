<?php

namespace App\Exceptions;

use App\Enums\Messages;
use Exception;
use Throwable;

class BanUserException extends Exception
{

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = Messages::FAILED_TO_BAN_USER;
        parent::__construct($message, $code, $previous);
    }

}
