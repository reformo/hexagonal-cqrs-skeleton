<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Query;

use Reformo\Domain\User\Interfaces\UserRepository;
use Reformo\Domain\User\Persistence\Doctrine\FetchObject\Users;

class GetAllUsersHandler
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param GetAllUsers $command
     * @return Users
     */
    public function __invoke(GetAllUsers $command) : Users
    {
        return $this->repository->getAllUsersPaginated($command->offset(), $command->limit());
    }
}
