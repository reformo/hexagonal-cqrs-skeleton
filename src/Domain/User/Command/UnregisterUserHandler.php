<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Command;

use Reformo\Common\Exception\ExecutionFailed;
use Reformo\Domain\User\Exception\UserNotFound;
use Reformo\Domain\User\Interfaces\UserRepository;
use Reformo\Domain\User\Model\UserId;

class UnregisterUserHandler
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws UserNotFound
     * @throws ExecutionFailed
     */
    public function __invoke(UnregisterUser $command) : void
    {
        $this->repository->unregisterUser(UserId::createFromString($command->id()));
    }
}
