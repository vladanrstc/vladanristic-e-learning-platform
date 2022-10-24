<?php

namespace App\Modules\Stats\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Stats\Command\ICommandManager;
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
     * @var IFormatterFactory
     */
    private IFormatterFactory $formatterFactory;

    /**
     * @var ICommandManager
     */
    private ICommandManager $commandManager;

    public function __construct(
        IFormatterFactory $formatterFactory,
        ICommandManager $commandManager
    ) {
        $this->formatterFactory = $formatterFactory;
        $this->commandManager   = $commandManager;
    }

    /**
     * @param  Request  $request
     * @param $commandName
     * @return Response|Application|ResponseFactory
     */
    public function executeCommand(Request $request, $commandName): Response|Application|ResponseFactory
    {
        $command = $this->commandManager->getCommand($commandName, $request->all());
        return response(
            $this->formatterFactory->createFormatter(
                $formatType = $request->get('format-type') ?? 'json')->formatResponse(
                $command->execute()
            ), $command->getStatus(),
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

}
