<?php

declare(strict_types=1);

namespace Reformo\PrivateApi\Handler\Users;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Reformo\Common\Interfaces\CommandBus;
use Reformo\Domain\User\Command\UnregisterUser as UnregisterUserCommand;
use Zend\Diactoros\Response\EmptyResponse;

class UnregisterUser implements RequestHandlerInterface
{
    private $config;
    private $commandBus;

    public function __construct(
        CommandBus $commandBus,
        array $config
    ) {
        $this->config     = $config;
        $this->commandBus = $commandBus;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $command = new UnregisterUserCommand($request->getAttribute('userId'));
        $this->commandBus->handle($command);

        return new EmptyResponse(204);
    }
}
