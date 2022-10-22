<?php

namespace App\ResponseFormatter;

interface IFormatterFactory
{

    public function createFormatter(string $formatterType): ResponseFormatterCreator;

}
