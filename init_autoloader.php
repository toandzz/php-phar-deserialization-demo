<?php

spl_autoload_register(function ($class) {
    $zf2Path = realpath(__DIR__ . '/vendor/Zend');
    if (strpos($class, 'Zend\\') === 0) {
        $classPath = $zf2Path . '/' . str_replace('\\', '/', substr($class, 5)) . '.php';
        if (file_exists($classPath)) {
            require $classPath;
        }
    }

    // Autoload cho namespace Application\
    $appPath = realpath(__DIR__ . '/module/Application/src/Application');
    if (strpos($class, 'Application\\') === 0) {
        $classPath = $appPath . '/' . str_replace('\\', '/', substr($class, strlen('Application\\'))) . '.php';
        if (file_exists($classPath)) {
            require $classPath;
        }
    }
});
