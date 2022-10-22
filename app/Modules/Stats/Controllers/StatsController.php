<?php

namespace App\Modules\Stats\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Stats\Services\IStatsService;
use App\ResponseFormatter\IFormatterFactory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\ArrayShape;

class StatsController extends Controller
{

    /**
     * @var IStatsService
     */
    private IStatsService $statsService;

    /**
     * @var IFormatterFactory
     */
    private IFormatterFactory $formatterFactory;

    public function __construct(IStatsService $statsService, IFormatterFactory $formatterFactory)
    {
        $this->statsService     = $statsService;
        $this->formatterFactory = $formatterFactory;
    }

    /**
     * @param  Request  $request
     * @return Response|Application|ResponseFactory
     */
    public function generalStats(Request $request): Response|Application|ResponseFactory
    {
        return response(
            $this->formatterFactory->createFormatter(
                $formatType = $request->get('format-type') ?? 'json')->formatResponse(
                $this->statsService->getAppStats()
            ),
            200,
            $this->formatContentType($formatType)
        );
    }

    /**
     * @param  string  $formatType
     * @return string[]
     */
    #[ArrayShape(["Content-Type" => "string"])]
    private function formatContentType(string $formatType): array
    {
        return [
            "Content-Type" => "application/{$formatType}"
        ];
    }

    /**
     * @param  Request  $request
     * @return Response|Application|ResponseFactory
     */
    public function lastThreeVideos(Request $request): Response|Application|ResponseFactory
    {
        return response(
            $this->formatterFactory->createFormatter(
                $formatType = $request->get('format-type') ?? 'json')->formatResponse(
                $this->statsService->getLastThreeVideos()
            ), 200,
            $this->formatContentType($formatType)
        );
    }


}
