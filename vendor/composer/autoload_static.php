<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit71bdf4beb056b688b3af0efd4bd86d07
{
    public static $files = array (
        '7166494aeff09009178f278afd86c83f' => __DIR__ . '/..' . '/yahnis-elsts/plugin-update-checker/load-v4p13.php',
    );

    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'BetterCollective\\WpPlugins\\DynamicShortcodeAPI\\' => 47,
            'BetterCollective\\WpPlugins\\DynamicShortcodeAPITest\\' => 51,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'BetterCollective\\WpPlugins\\DynamicShortcodeAPI\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'BetterCollective\\WpPlugins\\DynamicShortcodeAPITest\\' => 
        array (
            0 => __DIR__ . '/../..' . '/tests',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit71bdf4beb056b688b3af0efd4bd86d07::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit71bdf4beb056b688b3af0efd4bd86d07::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit71bdf4beb056b688b3af0efd4bd86d07::$classMap;

        }, null, ClassLoader::class);
    }
}
