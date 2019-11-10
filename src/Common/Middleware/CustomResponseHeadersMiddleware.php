<?php

declare(strict_types=1);

namespace Reformo\Common\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CustomResponseHeadersMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $response      = $handler->handle($request);
        $customHeaders = $request->getAttribute('custom-headers');
        foreach ($customHeaders as $customHeader => $customHeaderValue) {
            $response = $response->withHeader($customHeader, $customHeaderValue);
        }

        return $response;
    }
}
