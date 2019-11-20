<?php

declare(strict_types=1);

namespace Reformo\Common\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function array_merge;

class CustomResponseHeadersMiddleware implements MiddlewareInterface
{
    private $defaultHeaders;

    public function __construct(array $defaultHeaders)
    {
        $this->defaultHeaders = $defaultHeaders;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $response      = $handler->handle($request);
        $customHeaders = array_merge($this->defaultHeaders, $request->getAttribute('custom-headers'));
        foreach ($customHeaders as $customHeader => $customHeaderValue) {
            $response = $response->withHeader($customHeader, $customHeaderValue);
        }

        return $response;
    }
}
