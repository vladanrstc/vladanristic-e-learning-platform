<?php

namespace App\Modules\Auth\Enums;

enum Messages: string
{
    case INCORRECT_CREDENTIALS        = "Your credentials are incorrect. Please try again";
    case VERIFY_EMAIL                 = "Please verify your email";
    case VERIFY_EMAIL_NOT_SENT        = "Verification email for #{email} not sent";
    case EMAIL_VERIFICATION_FAILED    = "There was an error verifying your account";
    case RESET_PASSWORD_EMAIL_SUBJECT = "Reset your password";
    case RESET_PASSWORD_EXCEPTION     = "There was an error resetting your password. Please try again";
    case RESET_PASSWORD_EMAIL_SENT    = "We sent you a password reset email. Check your inbox";
}
