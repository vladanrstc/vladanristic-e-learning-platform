<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {moduleName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module in the application';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $DS         = DIRECTORY_SEPARATOR;
        $moduleName = ucfirst(strtolower($this->argument('moduleName')));
        File::makeDirectory(app_path().$DS."modules".$DS.$moduleName);
        File::makeDirectory(app_path().$DS."modules".$DS.$moduleName.$DS."Controllers");
        File::makeDirectory(app_path().$DS."modules".$DS.$moduleName.$DS."Enums");
        File::makeDirectory(app_path().$DS."modules".$DS.$moduleName.$DS."Exceptions");
        File::makeDirectory(app_path().$DS."modules".$DS.$moduleName.$DS."Messages");
        File::put(app_path().$DS."modules".$DS.$moduleName.$DS."Messages".$DS."en.json", "{}");
        File::put(app_path().$DS."modules".$DS.$moduleName.$DS."Messages".$DS."sr.json", "{}");
        File::makeDirectory(app_path().$DS."modules".$DS.$moduleName.$DS."Requests");
        File::makeDirectory(app_path().$DS."modules".$DS.$moduleName.$DS."Services");
        File::makeDirectory(app_path().$DS."modules".$DS.$moduleName.$DS."ResponseFormatters");
        File::makeDirectory(app_path().$DS."modules".$DS.$moduleName.$DS."Providers");
        File::makeDirectory(app_path().$DS."modules".$DS.$moduleName.$DS."DTOs");
        File::put(app_path().$DS."modules".$DS.$moduleName.$DS."routes.php", "<?php");

        return 0;
    }
}
