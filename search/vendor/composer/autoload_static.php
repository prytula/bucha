<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5e69b32dae91bfe35ca437b8634c0272
{
    public static $files = array (
        'aeae3a30876205414c5e6ecb8b973e42' => __DIR__ . '/../..' . '/config/config.php',
        '98175a6e3713ca9ed8d887bdeb485699' => __DIR__ . '/..' . '/google-api/vendor/autoload.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Search\\' => 7,
        ),
        'C' => 
        array (
            'Cli\\Command\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Search\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Cli\\Command\\' => 
        array (
            0 => __DIR__ . '/../..' . '/cli/Command',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5e69b32dae91bfe35ca437b8634c0272::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5e69b32dae91bfe35ca437b8634c0272::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5e69b32dae91bfe35ca437b8634c0272::$classMap;

        }, null, ClassLoader::class);
    }
}
