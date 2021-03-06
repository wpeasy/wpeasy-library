<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4802a2f2ff0b26bd822a9069efdd501c
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WPEasyLibrary\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WPEasyLibrary\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/WPEasyLibrary',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4802a2f2ff0b26bd822a9069efdd501c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4802a2f2ff0b26bd822a9069efdd501c::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
