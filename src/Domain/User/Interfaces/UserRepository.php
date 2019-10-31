<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Interfaces;

use Reformo\Domain\User\Interfaces\UserId as UserIdInterface;
use Reformo\Domain\User\Model\User;
use Reformo\Domain\User\Model\UsersCollection;

interface UserRepository
{
    public function get(UserIdInterface $id) : User;

    public function add(User $user) : bool;

    public function getAllUsersPaginated(int $offset, int $limit) : UsersCollection;
}
