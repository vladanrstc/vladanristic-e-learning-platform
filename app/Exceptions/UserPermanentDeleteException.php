<?php

namespace App\Exceptions;

use App\Enums\Messages;
use Exception;
use Throwable;

class UserPermanentDeleteException extends Exception
{

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = Messages::FAILED_TO_PERMANENTLY_DELETE_USER;
        parent::__construct($message, $code, $previous);
    }

}
