<?php
/**
 * Script for clearing the configuration cache.
 *
 * Can also be invoked as `composer clear-config-cache`.
 *
 * @see       https://github.com/mezzio/mezzio-skeleton for the canonical source repository
 * @copyright Copyright (c) 2017 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/mezzio/mezzio-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

chdir(__DIR__ . '/../');

$configFiles = glob('data/cache/*config-cache.php');

if (count($configFiles) === 0) {
    echo "No configuration cache path found" . PHP_EOL;
    exit(0);
}
foreach ($configFiles as $configFile) {
    if (!file_exists($configFile)) {
        printf(
            "Configured config cache file '%s' not found%s",
            $configFile,
            PHP_EOL
        );
        exit(0);
    }

    if (false === unlink($configFile)) {
        printf(
            "Error removing config cache file '%s'%s",
            $configFile,
            PHP_EOL
        );
        exit(1);
    }

    printf(
        "Removed configured config cache file '%s'%s",
        $configFile,
        PHP_EOL
    );
}
exit(0);
