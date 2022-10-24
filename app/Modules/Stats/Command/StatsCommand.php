<?php

namespace App\Modules\Stats\Command;

abstract class StatsCommand
{

    /**
     * @var array
     */
    protected array $params;
    protected int   $status;
    protected       $result;

    /**
     * @param  array  $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public abstract function execute();

    public function getStatus(): int
    {
        return $this->status;
    }

}
