<?php

namespace App\Modules\Auth\Exceptions;

use Exception;
use Throwable;

class UserAlreadyExistsException extends Exception
{

    public function __construct($email = "", $code = 0, Throwable $previous = null)
    {

        $message = "User with email $email already exists";
        if ($email == "") {
            $message = "User with email already exists";
        }

        parent::__construct($message, $code, $previous);

    }

}
