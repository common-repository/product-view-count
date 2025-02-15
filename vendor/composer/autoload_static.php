<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit046624d9f66d9b96e64941e147fe4f30
{
    public static $files = array (
        'f926a58910b2f2c0ae8c051092186a02' => __DIR__ . '/../..' . '/inc/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WPPlugines\\Product_View_Count\\App\\' => 34,
            'WPPlugines\\Product_View_Count\\API\\' => 34,
            'WPPlugines\\Product_View_Count\\' => 30,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WPPlugines\\Product_View_Count\\App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'WPPlugines\\Product_View_Count\\API\\' => 
        array (
            0 => __DIR__ . '/../..' . '/api',
        ),
        'WPPlugines\\Product_View_Count\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
    );

    public static $classMap = array (
        'Codexpert\\Plugin\\Base' => __DIR__ . '/..' . '/codexpert/plugin/src/Base.php',
        'Codexpert\\Plugin\\Deactivator' => __DIR__ . '/..' . '/codexpert/plugin/src/Deactivator.php',
        'Codexpert\\Plugin\\Feature' => __DIR__ . '/..' . '/codexpert/plugin/src/Feature.php',
        'Codexpert\\Plugin\\Fields' => __DIR__ . '/..' . '/codexpert/plugin/src/Fields.php',
        'Codexpert\\Plugin\\License' => __DIR__ . '/..' . '/codexpert/plugin/src/License.php',
        'Codexpert\\Plugin\\Metabox' => __DIR__ . '/..' . '/codexpert/plugin/src/Metabox.php',
        'Codexpert\\Plugin\\Notice' => __DIR__ . '/..' . '/codexpert/plugin/src/Notice.php',
        'Codexpert\\Plugin\\Settings' => __DIR__ . '/..' . '/codexpert/plugin/src/Settings.php',
        'Codexpert\\Plugin\\Setup' => __DIR__ . '/..' . '/codexpert/plugin/src/Setup.php',
        'Codexpert\\Plugin\\Survey' => __DIR__ . '/..' . '/codexpert/plugin/src/Survey.php',
        'Codexpert\\Plugin\\Table' => __DIR__ . '/..' . '/codexpert/plugin/src/Table.php',
        'Codexpert\\Plugin\\Update' => __DIR__ . '/..' . '/codexpert/plugin/src/Update.php',
        'Codexpert\\Plugin\\Widget' => __DIR__ . '/..' . '/codexpert/plugin/src/Widget.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit046624d9f66d9b96e64941e147fe4f30::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit046624d9f66d9b96e64941e147fe4f30::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit046624d9f66d9b96e64941e147fe4f30::$classMap;

        }, null, ClassLoader::class);
    }
}
