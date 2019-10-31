<?php
/**
 * Script for clearing the configuration cache.
 *
 * Can also be invoked as `composer clear-config-cache`.
 *
 * @see       https://github.com/zendframework/zend-expressive-skeleton for the canonical source repository
 * @copyright Copyright (c) 2017 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-expressive-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

chdir(__DIR__ . '/../');

$routeFiles = glob('data/cache/*-route.php.cache');

if (count($routeFiles) === 0) {
    echo "No route cache path found" . PHP_EOL;
    exit(0);
}
foreach ($routeFiles as $routeFile) {
    if (!file_exists($routeFile)) {
        printf(
            "Configured route cache file '%s' not found%s",
            $routeFile,
            PHP_EOL
        );
        exit(0);
    }

    if (false === unlink($routeFile)) {
        printf(
            "Error removing route cache file '%s'%s",
            $routeFile,
            PHP_EOL
        );
        exit(1);
    }

    printf(
        "Removed configured route cache file '%s'%s",
        $routeFile,
        PHP_EOL
    );
}
exit(0);
