<?php

namespace App\Console\Commands\FileBlueprints;

class FileBlueprint
{

    /**
     * @param $moduleName
     * @param $controllerName
     * @return string
     */
    public static function controllerBluePrint($moduleName, $controllerName): string
    {
        return str_replace(
            '\n', "\n", ("<?php" . "\\n" . "namespace App\\Modules\\" .
            $moduleName . "\\Controllers;" . "\\n\\n" .
            "use Illuminate\\Routing\\Controller;" . "\\n\\n" .
            "class {$controllerName}Controller extends Controller {" . "\\n\\n" . "}"));
    }

    /**
     * @param $moduleName
     * @param $serviceName
     * @return string
     */
    public static function serviceInterfaceBluePrint($moduleName, $serviceName): string
    {
        return str_replace(
            '\n', "\n", ("<?php" . "\\n\\n" . "namespace App\\Modules\\" .
            $moduleName . "\\Services;" . "\\n\\n" .
            "interface I{$serviceName}Service {" . "\\n\\n" . "}"));
    }

    /**
     * @param $moduleName
     * @param $serviceName
     * @return string
     */
    public static function serviceImplBluePrint($moduleName, $serviceName): string
    {
        return str_replace(
            '\n', "\n", ("<?php" . "\\n\\n" . "namespace App\\Modules\\" .
            $moduleName . "\\Services;" . "\\n\\n" .
            "class {$serviceName}ServiceImpl implements I{$serviceName}Service {" . "\\n\\n" . "}"));
    }

    /**
     * @param $moduleName
     * @param $exceptionName
     * @return string
     */
    public static function exceptionBluePrint($moduleName, $exceptionName): string
    {
        return str_replace(
            '\n', "\n", ("<?php" . "\\n\\n" . "namespace App\\Modules\\" .
            $moduleName . "\\Exceptions;" . "\\n\\n" .
            "use Exception;" . "\\n\\n" .
            "class {$exceptionName}Exception extends Exception {" . "\\n\\n" . "}"));
    }

    /**
     * @param $moduleName
     * @param $enumName
     * @return string
     */
    public static function enumBluePrint($moduleName, $enumName): string
    {
        return str_replace(
            '\n', "\n", ("<?php" . "\\n\\n" . "namespace App\\Modules\\" .
            $moduleName . "\\Enums;" . "\\n\\n" .
            "enum {$enumName}: string {" . "\\n\\n" . "}"));
    }

}
