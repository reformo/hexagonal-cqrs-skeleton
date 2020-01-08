<?php
declare(strict_types=1);

use Reformo\Common\Middleware\CustomResponseHeadersMiddleware;
use Reformo\Common\Middleware\CustomResponseHeadersMiddlewareFactory;
use Mezzio\Helper;

return [
    'dependencies' => [
        'aliases' => [],
        'invokables' => [
            Helper\ContentLengthMiddleware::class => Helper\ContentLengthMiddleware::class,
        ],
        'factories'  => [
            CustomResponseHeadersMiddleware::class => CustomResponseHeadersMiddlewareFactory::class
        ],
    ],
];
