<?php

namespace App\Decorators;

use App\Enums\Modules;
use App\Lang\ILangHelper;

class ErrorLangHelper implements ILangHelper
{

    /**
     * @var ILangHelper
     */
    private ILangHelper $langHelper;

    /**
     * @param  ILangHelper  $langHelper
     */
    public function __construct(ILangHelper $langHelper)
    {
        $this->langHelper = $langHelper;
    }

    /**
     * @param  string  $key
     * @param  Modules  $module
     * @param  string|null  $language
     * @return string
     */
    public function getMessage(string $key, Modules $module, string $language = null): string
    {
        return "ERROR " . $this->langHelper->getMessage($key, $module, $language);
    }
}
