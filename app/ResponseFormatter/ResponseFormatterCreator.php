<?php

namespace App\ResponseFormatter;

use App\ResponseFormatter\Formatter\Formatter;

abstract class ResponseFormatterCreator
{

    /**
     * @param  array  $data
     * @return mixed
     */
    public function formatResponse(array $data): mixed
    {
        return $this->createFormatter()->formatResponse($data);
    }

    public abstract function createFormatter(): Formatter;

}
