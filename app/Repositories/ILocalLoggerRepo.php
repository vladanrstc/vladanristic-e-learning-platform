<?php

namespace App\Repositories;

interface ILocalLoggerRepo
{

    public function logEvent(string $eventMessage);

}
