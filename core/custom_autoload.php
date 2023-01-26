<?php

$files = [
    __DIR__ . '/globals/pure_functions.php',
    __DIR__ . '/globals/global_constants.php',
    __DIR__ . '/globals/global_functions.php',
];

foreach ($files as $file) {
    require_once $file;
}

$toMap = require __DIR__ . '/../loader.php';

foreach ($toMap as $prefix => $baseDir) {
    spl_autoload_register(function ($class) use ($prefix, $baseDir) {
        $baseDir = BASE_PATH . "/{$baseDir}";

        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            return;
        }

        $relativeClass = substr($class, $len);

        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

        if (file_exists($file)) {
            require $file;
        }
    });
}
