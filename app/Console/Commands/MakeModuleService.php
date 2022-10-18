<?php

namespace App\Console\Commands;

use App\Console\Commands\FileBlueprints\FileBlueprint;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModuleService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module-service {moduleName} {serviceName}';

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

        $DS          = DIRECTORY_SEPARATOR;
        $moduleName  = ucfirst(strtolower($this->argument('moduleName')));
        $serviceName = ucfirst(strtolower($this->argument('serviceName')));

        File::put(
            app_path() . $DS . "modules" . $DS . $moduleName . $DS . "Services" . $DS . "I{$serviceName}Service.php",
            FileBlueprint::serviceInterfaceBluePrint($moduleName, $serviceName));

        File::put(
            app_path() . $DS . "modules" . $DS . $moduleName . $DS . "Services" . $DS . "{$serviceName}ServiceImpl.php",
            FileBlueprint::serviceImplBluePrint($moduleName, $serviceName));

        return 0;
    }
}
