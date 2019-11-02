<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Query;

use Reformo\Domain\User\Interfaces\UserQuery;
use Reformo\Domain\User\Model\UserId;
use Reformo\Domain\User\Persistence\FetchObject\User;

class GetUserByIdHandler
{
    private $query;

    public function __construct(UserQuery $repository)
    {
        $this->query = $repository;
    }

    public function __invoke(GetUserById $command) : User
    {
        return $this->query
            ->getUserById(UserId::createFromString($command->id()));
    }
}
