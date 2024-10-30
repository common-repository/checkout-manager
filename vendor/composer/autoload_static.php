<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2493d738ae265fa709ad7990970afbaf
{
    public static $files = array (
        '6fcb2a5ef72b2d1b221fd4b32c39d352' => __DIR__ . '/../..' . '/inc/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WPPlugines\\Checkout_Manager\\App\\' => 32,
            'WPPlugines\\Checkout_Manager\\' => 28,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WPPlugines\\Checkout_Manager\\App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'WPPlugines\\Checkout_Manager\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2493d738ae265fa709ad7990970afbaf::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2493d738ae265fa709ad7990970afbaf::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}