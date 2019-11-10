<?php

declare(strict_types=1);

namespace Reformo\Common\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Reformo\Common\ValueObject\AcceptHeaderNegotiator;

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
class ApiContentNegotiationMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $acceptHeader = $request->getHeaderLine('accept');
        $negotiator       = AcceptHeaderNegotiator::createFromAcceptHeader($acceptHeader);
        $preferredContent = $negotiator->getBest();
        $request          = $request->withAttribute('accept-version', $preferredContent->version() ?? '1');
        $request          = $request->withAttribute('accept-content-type', $preferredContent->type());
        $request          = $request->withAttribute('accept-charset', $preferredContent->charset());
        $customHeaders    = [
            'Content-Type' =>  $preferredContent->type(),
        ];
        if ($preferredContent->version() !== null) {
            $customHeaders['X-Api-Version'] = $preferredContent->version();
        }
        $request = $request->withAttribute('custom-headers', $customHeaders);

        return $handler->handle($request);
    }
}
