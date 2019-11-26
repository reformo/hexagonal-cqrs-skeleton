<?php
declare(strict_types=1);

use Reformo\Common\Middleware\CustomResponseHeadersMiddleware;
use Reformo\Common\Middleware\CustomResponseHeadersMiddlewareFactory;
use Zend\Expressive\Helper;

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
