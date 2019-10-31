<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Query;

use Reformo\Domain\User\Interfaces\UserRepository;
use Reformo\Domain\User\Model\User;

class GetUserHandler
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetUser $command) : User
    {
        return $this->repository->get($command->id);
    }
}
