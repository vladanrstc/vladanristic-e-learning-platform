<?php

namespace App\Console\Commands;

use App\Console\Commands\FileBlueprints\FileBlueprint;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModuleException extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module-exception {moduleName} {exceptionName}';

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

        $DS            = DIRECTORY_SEPARATOR;
        $moduleName    = ucfirst(strtolower($this->argument('moduleName')));
        $exceptionName = ucfirst(strtolower($this->argument('exceptionName')));

        File::put(
            app_path() . $DS . "modules" . $DS . $moduleName . $DS . "Exceptions" . $DS . "{$exceptionName}Exception.php",
            FileBlueprint::exceptionBluePrint($moduleName, $exceptionName));

        return 0;
    }
}
