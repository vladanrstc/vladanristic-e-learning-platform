<?php

namespace App\Lang;

use App\Enums\Modules;

interface ILangHelper
{
    public function getMessage(string $key, Modules $module, string $language = null): string;
}
