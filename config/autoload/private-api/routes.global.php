<?php

declare(strict_types=1);

return [

    'router' => [
        'fastroute' => [
            'cache_enabled' => filter_var(getenv('ENABLE_ROUTES_CACHE'), FILTER_VALIDATE_BOOLEAN),
            'cache_file'    => 'data/cache/private-api-route.php.cache',
        ],
    ],
    'private-api-app' => [

    ],

];