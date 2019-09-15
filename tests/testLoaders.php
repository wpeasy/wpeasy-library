<?php

use WPEasyLibrary\Loaders\StaticModuleDirLoader;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$loader = new StaticModuleDirLoader(
    __DIR__ . '/WPETests/Modules',
    'WPETests',
    '\Controller\ModuleController'
);


//Should error
try{
    $loader->initSpecificModules(['TestModule','AnotherTestModule','NoExistent']);
}catch (Exception $e){
    echo $e->getMessage();
};
