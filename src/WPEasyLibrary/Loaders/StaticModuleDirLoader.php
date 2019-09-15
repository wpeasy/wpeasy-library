<?php
namespace WPEasyLibrary\Loaders;
use WPEasyLibrary\Interfaces\IStaticInitialiser;


class StaticModuleDirLoader
{

    static function initModules($moduleDir, $rootClassName, $frontControllerName = 'Controller\ModuleController')
    {
        $modules = scandir($moduleDir);
        $classRoot = $rootClassName . '\\' . trim(explode($rootClassName, $moduleDir)[1], '/\\');

        foreach($modules as $module)
        {
            if(in_array($module, ['.','..'])) continue;

            /**@var $class IStaticInitialiser */
            $class = $classRoot. '\\' . $module . $frontControllerName;

            $class::init();
        }

    }
}