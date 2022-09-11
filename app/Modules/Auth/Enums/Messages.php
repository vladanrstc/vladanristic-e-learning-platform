<?php

namespace App\Modules\Auth\Enums;

enum Messages: string
{
    case VERIFY_EMAIL_NOT_SENT    = "Verification email for #{email} not sent";
    case RESET_PASSWORD_EXCEPTION = "There was an error resetting your password. Please try again";
}
