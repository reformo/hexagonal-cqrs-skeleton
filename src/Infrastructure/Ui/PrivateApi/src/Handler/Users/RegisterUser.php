<?php

declare(strict_types=1);

namespace Reformo\PrivateApi\Handler\Users;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ramsey\Uuid\Uuid;
use Reformo\Common\Services\MessageBus\Interfaces\CommandBus;
use Reformo\Domain\User\Command\RegisterUser as RegisterUserCommand;
use Zend\Diactoros\Response\EmptyResponse;

class RegisterUser implements RequestHandlerInterface
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
        $command           = new RegisterUserCommand(
            Uuid::uuid4()->toString(),
            $requestParameters['first_name'],
            $requestParameters['last_name'],
            $requestParameters['email']
        );
        $this->commandBus->handle($command);

        return new EmptyResponse(201, [
            'Location' => $request->getAttribute('base-url') . '/users/' . $command->id(),
        ]);
    }
}
