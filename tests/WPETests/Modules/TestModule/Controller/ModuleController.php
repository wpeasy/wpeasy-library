<?php


namespace WPETests\Modules\TestModule\Controller;

use WPEasyLibrary\Interfaces\IStaticInitialiser;

class ModuleController implements IStaticInitialiser
{

    static function init()
    {
        // TODO: Implement init() method.
        echo __METHOD__;
    }
}