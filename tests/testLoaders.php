<?php

use WPEasyLibrary\Loaders\StaticModuleDirLoader;

require_once dirname(__DIR__) . '/vendor/autoload.php';

StaticModuleDirLoader::initModules(
    __DIR__ . '/WPETests/Modules',
    'WPETests',
    '\Controller\ModuleController'
);