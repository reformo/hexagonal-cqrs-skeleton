<?php

declare(strict_types=1);

namespace Reformo\PrivateApi\Handler\Users;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Reformo\Common\Interfaces\CommandBus;
use Reformo\Domain\User\Command\UpdateUserPartially;
use Zend\Diactoros\Response\EmptyResponse;

class ReplaceUser implements RequestHandlerInterface
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
        $requestParameters = $request->getParsedBody();
        $command           = new UpdateUserPartially($request->getAttribute('userId'), $requestParameters);
        $this->commandBus->handle($command);

        return new EmptyResponse(204, [
            'Location' => $request->getAttribute('base-url') . '/users/' . $command->id(),
        ]);
    }
}
