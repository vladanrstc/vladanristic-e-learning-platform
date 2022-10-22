<?php

namespace App\ResponseFormatter;

use App\ResponseFormatter\Formatter\JSONFormatter;

class JSONFormatterCreator extends ResponseFormatterCreator
{

    /**
     * @return JSONFormatter
     */
    public function createFormatter(): JSONFormatter
    {
        return new JSONFormatter();
    }

}
