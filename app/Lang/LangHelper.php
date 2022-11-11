<?php

namespace App\Lang;

use App\Enums\Languages;
use App\Enums\Modules;
use App\Exceptions\MessageTranslationNotFoundException;
use Illuminate\Support\Facades\App;

class LangHelper implements ILangHelper
{

    /**
     * @param  string  $key
     * @param  Modules  $module
     * @param  string|null  $language
     * @return string
     * @throws MessageTranslationNotFoundException
     */
    public function getMessage(string $key, Modules $module, string $language = null): string
    {

        is_null($language) ? $language = App::getLocale() : null;

        $messages = json_decode(
            file_get_contents(
                base_path(
                    "app" . DIRECTORY_SEPARATOR . "Modules" . DIRECTORY_SEPARATOR . $module->value . DIRECTORY_SEPARATOR . "Messages" . DIRECTORY_SEPARATOR . $language . ".json")),
            true);

        if (isset($messages[$key])) {
            return $messages[$key];
        }

        throw new MessageTranslationNotFoundException("Cannot find message translation for {$key} key");

    }

}
