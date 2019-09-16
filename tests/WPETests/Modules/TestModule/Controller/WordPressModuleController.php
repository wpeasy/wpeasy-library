<?php


namespace WPETests\Modules\TestModule\Controller;

use WPEasyLibrary\Interfaces\IWordPressModule;
use WPEasyLibrary\Interfaces\IStaticInitialiser;

class WordPressModuleController implements IStaticInitialiser, IWordPressModule
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