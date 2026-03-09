<?php
spl_autoload_register(function ($class) {
    $prefixes = [
        'League\\OAuth2\\Client\\' => __DIR__ . '/oauth/oauth2-client/src/',
        'League\\OAuth2\\Client\\Provider\\Google' => __DIR__ . '/oauth/oauth2-google/src/',
    ];

    foreach ($prefixes as $prefix => $baseDir) {
        if (strpos($class, $prefix) === 0) {
            $relativeClass = str_replace($prefix, '', $class);
            $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

            if (file_exists($file)) {
                require $file;
                return;
            }
        }
    }
});
