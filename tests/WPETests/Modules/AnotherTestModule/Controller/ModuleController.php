<?php


namespace WPETests\Modules\AnotherTestModule\Controller;


use WPEasyLibrary\Interfaces\IStaticInitialiser;

class ModuleController implements IStaticInitialiser
{
    static $name = 'Another one';
    static $description = 'Another Description';
    static function init()
    {
        // TODO: Implement init() method.

    }
}