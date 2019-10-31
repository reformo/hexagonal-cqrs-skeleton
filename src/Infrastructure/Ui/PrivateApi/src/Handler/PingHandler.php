<?php

declare(strict_types=1);

namespace Reformo\PrivateApi\Handler;

use League\Tactician\CommandBus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Reformo\Domain\User\Command\RegisterUser;
use Zend\Diactoros\Response\JsonResponse;

class PingHandler implements RequestHandlerInterface
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
        $command               = new RegisterUser();
        $command->emailAddress = 'alice@example.com';
        $command->password     = 'secret';

        return new JsonResponse([
            'welcome' => 'Congratulations! You have installed the zend-expressive skeleton application.',
            'docsUrl' => 'https://docs.zendframework.com/zend-expressive/',
            'command' => $this->commandBus->handle($command),
        ]);
    }
}
