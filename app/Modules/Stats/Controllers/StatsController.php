<?php

namespace App\Modules\Stats\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Stats\Services\IStatsService;
use Illuminate\Http\JsonResponse;

class StatsController extends Controller
{

    /**
     * @var IStatsService
     */
    private IStatsService $statsService;

    public function __construct(IStatsService $statsService)
    {
        $this->statsService = $statsService;
    }

    /**
     * @return JsonResponse
     */
    public function generalStats(): JsonResponse
    {
        return response()->json(["data" => $this->statsService->getAppStats()]);
    }

    /**
     * @return JsonResponse
     */
    public function lastThreeVideos(): JsonResponse
    {
        return response()->json(["data" => $this->statsService->getLastThreeVideos()]);
    }

}
