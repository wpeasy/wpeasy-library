<?php


namespace WPETests\Modules\TestModule\Controller;

use WPEasyLibrary\Interfaces\IModule;
use WPEasyLibrary\Interfaces\IStaticInitialiser;

class ModuleController implements IStaticInitialiser, IModule
{
    static $name = 'Test Module';
    static $description = 'Test to see if this loader works';

    static function init()
    {
        // TODO: Implement init() method.
        echo __METHOD__;
    }

    static function activate()
    {
        // TODO: Implement activate() method.
    }

    static function deactivate()
    {
        // TODO: Implement deactivate() method.
    }

    static function upgrade()
    {
        // TODO: Implement upgrade() method.
    }
}