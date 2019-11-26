<?php

declare(strict_types=1);

namespace Reformo\Common\Middleware\ContentNegotiation;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ApiContentNegotiationMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $acceptHeader     = $request->getHeaderLine('accept');
        $negotiator       = AcceptHeaderNegotiator::createFromAcceptHeader($acceptHeader);
        $preferredContent = $negotiator->getBest();
        $acceptVersion    = $preferredContent->version() ?? '1';
        $request          = $request->withAttribute('accept-version', $acceptVersion);
        $request          = $request->withAttribute('accept-content-type', $preferredContent->type());
        $request          = $request->withAttribute('accept-charset', $preferredContent->charset());
        $customHeaders    = [
            'Content-Type' =>  $preferredContent->type(),
        ];
        if ($preferredContent->version() !== null) {
            // No X prefix for application specific headers. Use vendor name instead.
            // See: RFC 6648 https://tools.ietf.org/html/rfc6648
            $customHeaders['Reformo-Api-Version'] = $preferredContent->version();
        }
        $request = $request->withAttribute('custom-headers', $customHeaders);

        return $handler->handle($request);
    }
}
