<?php

declare(strict_types=1);

namespace Reformo\Common\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Selami\Stdlib\BaseUrlExtractor;

/**
 * Emit a 405 Method Not Allowed response
 *
 * If the request composes a route result, and the route result represents a
 * failure due to request method, this middleware will emit a 405 response,
 * along with an Allow header indicating allowed methods, as reported by the
 * route result.
 *
 * If no route result is composed, and/or it's not the result of a method
 * failure, it passes handling to the provided handler.
 */
class BaseUrlMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $serverParameters = $request->getServerParams();
        $serverParameters['HTTP_HOST'] = $serverParameters['HTTP_HOST'] ?? $request->getHeader('host')[0] ?? '';
        $serverParameters['SCRIPT_NAME'] = $serverParameters['SCRIPT_NAME'] ?? '';
        $serverParameters['PHP_SELF'] = $serverParameters['PHP_SELF'] ?? '';
        $request = $request->withAttribute('base-url', BaseUrlExtractor::getBaseUrl($serverParameters));
        return $handler->handle($request);
    }
}
