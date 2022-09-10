<?php

namespace App\Modules\Auth\Enums;

enum Messages: string
{
    case INCORRECT_CREDENTIALS = "Your credentials are incorrect. Please try again";
    case VERIFY_EMAIL          = "Please verify your email";
    case VERIFY_EMAIL_NOT_SENT = "Verification email for #{email} not sent";

}
