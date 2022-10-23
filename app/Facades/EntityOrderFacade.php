<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class EntityOrderFacade extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return "ReorderEntities";
    }

}
