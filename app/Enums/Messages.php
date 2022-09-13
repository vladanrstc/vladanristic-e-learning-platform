<?php

namespace App\Enums;

enum Messages: string
{
    case FAILED_TO_UPDATE_USER   = "Failed to update user model";
    case FAILED_TO_WRITE_TO_FILE = "Error writing file to disk!";
}
