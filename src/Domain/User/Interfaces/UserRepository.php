<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Interfaces;

use Reformo\Common\Exception\ExecutionFailed;
use Reformo\Common\ValueObject\Email;
use Reformo\Domain\User\Exception\UserNotFound;
use Reformo\Domain\User\Model\User;

interface UserRepository
{
    public function getUserById(UserId $id) : ?User;

    public function getUserByEmail(Email $email) : ?User;

    public function registerUser(User $user) : void;

    /**
     * @throws UserNotFound
     * @throws ExecutionFailed
     *
     * @var UserId
     */
    public function unregisterUser(UserId $id) : void;

    public function updateUserInfo(UserId $userId, array $payload) : void;
}
