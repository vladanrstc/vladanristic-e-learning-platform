<?php

namespace App\ResponseFormatter\Formatter;

interface Formatter
{
    public function formatResponse(array $data): array|string;
}
