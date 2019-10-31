<?php
declare(strict_types=1);

return [
    'twig' => [
        'cache_dir' => getenv('ENABLE_TWIG_CACHE') == 'false' ? false : getenv('ENABLE_TWIG_CACHE'),
        'debug' =>  filter_var(getenv('ENABLE_TWIG_DEBUG'), FILTER_VALIDATE_BOOLEAN),
        'optimizations' => -1,
        'auto_reload' => true
    ]
];