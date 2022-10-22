<?php

namespace App\ResponseFormatter\Formatter;

class XMLFormatter implements Formatter
{

    /**
     * Format to XML
     */
    public function formatResponse(array $data): string|array
    {
        return xmlrpc_encode($data);
    }

}
