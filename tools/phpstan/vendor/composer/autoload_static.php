<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita97982d1fd50e9e081e9c746e2612acb
{
    public static $files = array (
        '9b38cf48e83f5d8f60375221cd213eee' => __DIR__ . '/..' . '/phpstan/phpstan/bootstrap.php',
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInita97982d1fd50e9e081e9c746e2612acb::$classMap;

        }, null, ClassLoader::class);
    }
}
