<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit501fd3fef336129d9890d2d091624e7c
{
    public static $files = array (
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twig\\' => 5,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Polyfill\\Ctype\\' => 23,
        ),
        'D' => 
        array (
            'Doctrine\\DBAL\\' => 14,
            'Doctrine\\Common\\Cache\\' => 22,
            'Doctrine\\Common\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twig\\' => 
        array (
            0 => __DIR__ . '/..' . '/twig/twig/src',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Doctrine\\DBAL\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/dbal/lib/Doctrine/DBAL',
        ),
        'Doctrine\\Common\\Cache\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/cache/lib/Doctrine/Common/Cache',
        ),
        'Doctrine\\Common\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/event-manager/lib/Doctrine/Common',
        ),
    );

    public static $prefixesPsr0 = array (
        'B' => 
        array (
            'Bramus' => 
            array (
                0 => __DIR__ . '/..' . '/bramus/router/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'http\\AdminController' => __DIR__ . '/../..' . '/src/http/AdminController.php',
        'http\\AuthController' => __DIR__ . '/../..' . '/src/http/AuthController.php',
        'http\\MainController' => __DIR__ . '/../..' . '/src/http/MainController.php',
        'services\\DatabaseConnector' => __DIR__ . '/../..' . '/src/services/DatabaseConnector.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit501fd3fef336129d9890d2d091624e7c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit501fd3fef336129d9890d2d091624e7c::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit501fd3fef336129d9890d2d091624e7c::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit501fd3fef336129d9890d2d091624e7c::$classMap;

        }, null, ClassLoader::class);
    }
}
