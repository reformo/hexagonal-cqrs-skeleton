<?php

declare(strict_types=1);

namespace Reformo\FrontWeb\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Reformo\Common\Interfaces\CommandBus;
use Reformo\Domain\User\Command\UnregisterUser;
use Reformo\Domain\User\Exception\UserNotFound;
use Throwable;
use Zend\Diactoros\Response\RedirectResponse;
use function http_build_query;
use function urlencode;

class DeleteUserHandler implements RequestHandlerInterface
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
        $command = new UnregisterUser($request->getAttribute('userId'));
        try {
            $this->commandBus->handle($command);
        } catch (UserNotFound $exception) {
            $uri = $request->getAttribute('base-url') . '/?error=unregister-user-failed&' .
                http_build_query($request->getParsedBody()) . '&_reason=' . urlencode($exception->getMessage());

            return new RedirectResponse($uri, 302);
        } catch (Throwable $exception) {
            $uri = $request->getAttribute('base-url') . '/?error=execution-failed' .
                '&_reason=' . urlencode($exception->getMessage());

            return new RedirectResponse($uri, 302);
        }

        return new RedirectResponse($request->getAttribute('base-url') . '/', 302);
    }
}
