<?php

declare(strict_types=1);

namespace Reformo\PrivateApi\Handler\Users;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Reformo\Common\Interfaces\QueryBus;
use Reformo\Domain\User\Query\GetAllUsers;
use Zend\Diactoros\Response\JsonResponse;

class Users implements RequestHandlerInterface
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
        $query = new GetAllUsers(0, 25);
        $users = $this->queryBus->handle($query);

        return new JsonResponse(['users' => $users]);
    }
}
