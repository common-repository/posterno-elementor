<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitecd63999bfe248b7ae1995ee57de679e
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Posterno\\Elementor\\' => 19,
            'PosternoRequirements\\' => 21,
        ),
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Posterno\\Elementor\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes/classes',
        ),
        'PosternoRequirements\\' => 
        array (
            0 => __DIR__ . '/..' . '/posterno/addon-requirements-check/src',
        ),
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitecd63999bfe248b7ae1995ee57de679e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitecd63999bfe248b7ae1995ee57de679e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitecd63999bfe248b7ae1995ee57de679e::$classMap;

        }, null, ClassLoader::class);
    }
}
