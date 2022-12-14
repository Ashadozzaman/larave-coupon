<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit43fbbf489e21a38dfd3a7f53cebcaf33
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Ashadozzaman\\Coupon\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Ashadozzaman\\Coupon\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit43fbbf489e21a38dfd3a7f53cebcaf33::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit43fbbf489e21a38dfd3a7f53cebcaf33::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit43fbbf489e21a38dfd3a7f53cebcaf33::$classMap;

        }, null, ClassLoader::class);
    }
}
