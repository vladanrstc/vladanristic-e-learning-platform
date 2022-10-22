<?php

namespace App\ResponseFormatter\Formatter;

use JetBrains\PhpStorm\ArrayShape;

class JSONFormatter implements Formatter
{

    /**
     * Format response in JSON
     */
    #[ArrayShape(["data" => "array"])]
    public function formatResponse(array $data): string|array
    {
        return ["data" => $data];
    }

}
