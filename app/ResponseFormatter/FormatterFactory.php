<?php

namespace App\ResponseFormatter;

class FormatterFactory implements IFormatterFactory
{

    /**
     * @param  string  $formatterType
     * @return ResponseFormatterCreator
     */
    public function createFormatter(string $formatterType): ResponseFormatterCreator
    {
        return $this->getFormatter($formatterType);
    }

    /**
     * @param  string  $formatterType
     * @return ResponseFormatterCreator
     */
    private function getFormatter(string $formatterType): ResponseFormatterCreator
    {
        return call_user_func(
            [
                "json" => function (): JSONFormatterCreator {
                    return new JSONFormatterCreator();
                },
                'xml'  => function (): XMLFormatterCreator {
                    return new XMLFormatterCreator();
                }
            ][$formatterType]);
    }

}
