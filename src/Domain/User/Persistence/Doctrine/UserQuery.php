<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Persistence\Doctrine;

use Doctrine\DBAL\Connection;
use Reformo\Common\ValueObject\Interfaces\Email;
use Reformo\Domain\User\Interfaces\UserId;
use Reformo\Domain\User\Interfaces\UserQuery as UserQueryInterface;
use Reformo\Domain\User\Model\Users;
use Reformo\Domain\User\Persistence\Doctrine\ResultObject\User;
use Reformo\Domain\User\Persistence\Doctrine\SqlQuery\GetAllUsers;
use Reformo\Domain\User\Persistence\Doctrine\SqlQuery\GetUserByEmail;
use Reformo\Domain\User\Persistence\Doctrine\SqlQuery\GetUserById;

class UserQuery implements UserQueryInterface
{
    private const TABLE_NAME = 'users';
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getUserById(UserId $userId) : ?User
    {
        return GetUserById::execute($this->connection, ['userId' => $userId->toString()]);
    }

    public function getUserByEmail(Email $email) : ?User
    {
        return GetUserByEmail::execute($this->connection, ['email' => $email->toString()]);
    }

    public function getAllUsersPaginated(int $offset, int $limit) : Users
    {
        return GetAllUsers::execute($this->connection, ['offset' => $offset, 'limit' => $limit]);
    }
}
