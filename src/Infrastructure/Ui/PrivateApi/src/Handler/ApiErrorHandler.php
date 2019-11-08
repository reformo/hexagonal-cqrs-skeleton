<?php

declare(strict_types=1);

namespace Reformo\PrivateApi\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Reformo\Common\Exception\InvalidArgument;

class ApiErrorHandler implements RequestHandlerInterface
{
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        throw InvalidArgument::create('Invalid input', ['code' => 'AD-1224']);
    }
}
