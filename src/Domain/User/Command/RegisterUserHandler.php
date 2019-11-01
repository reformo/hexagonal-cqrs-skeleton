<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Command;

use Ramsey\Uuid\Uuid;
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
        $dateTime = (new \DateTimeImmutable('now'))->format(User::CREATED_AT_FORMAT);
        $user = User::create(
            $command->id(),
            $command->email(),
            $command->firstName(),
            $command->lastName(),
            $dateTime
        );
        $this->repository->add($user);
    }
}
