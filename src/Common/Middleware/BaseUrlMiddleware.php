<?php

declare(strict_types=1);

namespace Reformo\Common\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Selami\Stdlib\BaseUrlExtractor;

class BaseUrlMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $serverParameters                = $request->getServerParams();
        $serverParameters['HTTP_HOST']   = $serverParameters['HTTP_HOST'] ?? $request->getHeaderLine('host') ?? '';
        $serverParameters['SCRIPT_NAME'] = $serverParameters['SCRIPT_NAME'] ?? '';
        $serverParameters['PHP_SELF']    = $serverParameters['PHP_SELF'] ?? '';
        $request                         = $request
            ->withAttribute('base-url', BaseUrlExtractor::getBaseUrl($serverParameters));

        return $handler->handle($request);
    }
}
