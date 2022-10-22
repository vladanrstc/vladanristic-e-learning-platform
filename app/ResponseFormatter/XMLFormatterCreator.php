<?php

namespace App\ResponseFormatter;

use App\ResponseFormatter\Formatter\XMLFormatter;

class XMLFormatterCreator extends ResponseFormatterCreator
{

    /**
     * @return XMLFormatter
     */
    public function createFormatter(): XMLFormatter
    {
        return new XMLFormatter();
    }

}
