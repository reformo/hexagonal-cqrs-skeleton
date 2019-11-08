<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Command;

use Reformo\Domain\User\Interfaces\UserRepository;
use Reformo\Domain\User\Model\User;

class RegisterUserHandler
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(RegisterUser $command) : void
    {
        $user = User::create(
            $command->id(),
            $command->email(),
            $command->firstName(),
            $command->lastName()
        );
        $this->repository->registerUser($user);
    }
}
