<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Interfaces;

use Reformo\Common\Exception\ExecutionFailed;
use Reformo\Common\Interfaces\Email;
use Reformo\Domain\User\Exception\UserNotFound;
use Reformo\Domain\User\Model\User;
use Reformo\Domain\User\Model\UsersCollection;

interface UserRepository
{
    public function getUserById(UserId $id) : ?User;

    public function getUserByEmail(Email $email) : ?User;

    public function registerUser(User $user) : void;

    /**
     * @throws UserNotFound
     * @throws ExecutionFailed
     */
    public function unregisterUser(UserId $id) : void;

    public function getAllUsersPaginated(int $offset, int $limit) : UsersCollection;
}
