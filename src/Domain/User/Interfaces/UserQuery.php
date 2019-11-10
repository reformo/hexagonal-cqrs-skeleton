<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Interfaces;

use Reformo\Common\Interfaces\Email;
use Reformo\Domain\User\Interfaces\UserId as UserIdInterface;
use Reformo\Domain\User\Model\UsersCollection;
use Reformo\Domain\User\Persistence\Doctrine\ResultObject\User;

interface UserQuery
{
    public function getUserById(UserIdInterface $id) : ?User;

    public function getUserByEmail(Email $email) : ?User;

    public function getAllUsersPaginated(int $offset, int $limit) : UsersCollection;
}
