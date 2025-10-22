<?php
spl_autoload_register(function ($class) {
    $baseDir = __DIR__ . DIRECTORY_SEPARATOR;
    $file = $baseDir . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (is_file($file)) {
        require_once $file;
    }
});
