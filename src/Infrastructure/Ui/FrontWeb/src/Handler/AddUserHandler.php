<?php

declare(strict_types=1);

namespace Reformo\FrontWeb\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ramsey\Uuid\Uuid;
use Reformo\Common\Services\MessageBus\Interfaces\CommandBus;
use Reformo\Domain\User\Command\RegisterUser;
use Reformo\Domain\User\Exception\UserAlreadyExists;
use Throwable;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Csrf\CsrfMiddleware;
use function http_build_query;
use function urlencode;

class AddUserHandler implements RequestHandlerInterface
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
        $guard             = $request->getAttribute(CsrfMiddleware::GUARD_ATTRIBUTE);
        $requestParameters = $request->getParsedBody();
        $token             = $requestParameters['__csrf'] ?? '';
        if (! $guard->validateToken($token)) {
            $uri = $request->getAttribute('base-url') . '/?error=execution-failed' .
                '&_reason=' . urlencode('CSRF Failed: CSRF token missing or incorrect');

            return new RedirectResponse($uri, 302);
        }
        $command = new RegisterUser(
            Uuid::uuid4()->toString(),
            $requestParameters['first_name'],
            $requestParameters['last_name'],
            $requestParameters['email']
        );
        try {
            $this->commandBus->handle($command);
        } catch (UserAlreadyExists $exception) {
            $uri = $request->getAttribute('base-url') . '/?error=add-user-failed&' .
                http_build_query($request->getParsedBody()) . '&_reason=' . urlencode($exception->getMessage());

            return new RedirectResponse($uri, 302);
        } catch (Throwable $exception) {
            $uri = $request->getAttribute('base-url') . '/?error=execution-failed' .
                 '&_reason=' . urlencode($exception->getMessage());

            return new RedirectResponse($uri, 302);
        }

        return new RedirectResponse($request->getAttribute('base-url') . '/', 302);

        // You may also redirect to created user
        // return new RedirectResponse($request->getAttribute('base-url') . '/users' . $command->id(), 302);
    }
}
