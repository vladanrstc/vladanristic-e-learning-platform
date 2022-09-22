<?php

namespace App\Console\Commands;

use App\Console\Commands\FileBlueprints\FileBlueprint;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModuleEnum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module-enum {moduleName} {enumName}';

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

        $DS         = DIRECTORY_SEPARATOR;
        $moduleName = ucfirst(strtolower($this->argument('moduleName')));
        $enumName   = ucfirst(strtolower($this->argument('enumName')));

        File::put(app_path() . $DS . "modules" . $DS . $moduleName . $DS . "Enums" . $DS . "{$enumName}.php",
            FileBlueprint::enumBluePrint($moduleName, $enumName));

        return 0;
    }
}
