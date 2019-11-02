<?php

declare(strict_types=1);

namespace Reformo\PrivateApi\Handler\Users;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Reformo\Common\Interfaces\QueryBus;
use Reformo\Domain\User\Query\GetUserById;
use Zend\Diactoros\Response\JsonResponse;

class UserDetails implements RequestHandlerInterface
{
    private $config;
    private $queryBus;

    public function __construct(
        QueryBus $queryBus,
        array $config
    ) {
        $this->config   = $config;
        $this->queryBus = $queryBus;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $query = new GetUserById($request->getAttribute('userId'));
        $users = $this->queryBus->handle($query);

        return new JsonResponse([
            'user' => $users,
        ]);
    }
}
