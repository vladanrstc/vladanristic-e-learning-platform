<?php

namespace App\Console\Commands;

use App\Console\Commands\FileBlueprints\FileBlueprint;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModuleController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module-controller {moduleName} {controllerName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $DS             = DIRECTORY_SEPARATOR;
        $moduleName     = ucfirst(strtolower($this->argument('moduleName')));
        $controllerName = ucfirst(strtolower($this->argument('controllerName')));

        File::put(
            app_path() . $DS . "modules" . $DS . $moduleName . $DS . "Controllers" . $DS . "{$controllerName}Controller.php",
            FileBlueprint::controllerBluePrint($moduleName, $controllerName));


        return 0;
    }
}
