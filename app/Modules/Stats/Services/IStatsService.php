<?php

namespace App\Modules\Stats\Services;

interface IStatsService
{
    public function getAppStats(): array;

    public function getLastThreeVideos(): array;
}
