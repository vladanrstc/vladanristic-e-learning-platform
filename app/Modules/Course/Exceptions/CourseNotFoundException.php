<?php

namespace App\Modules\Course\Exceptions;

use App\Modules\Course\Enums\Messages;
use Exception;
use Throwable;

class CourseNotFoundException extends Exception
{

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = Messages::COURSE_NOT_FOUND->value;
        parent::__construct($message, $code, $previous);
    }

}
