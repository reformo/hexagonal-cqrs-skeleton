<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Persistence\Doctrine;

use Doctrine\DBAL\Connection;
use Reformo\Common\Interfaces\Email;
use Reformo\Domain\User\Interfaces\UserId;
use Reformo\Domain\User\Interfaces\UserQuery as UserQueryInterface;
use Reformo\Domain\User\Model\UsersCollection;
use Reformo\Domain\User\Persistence\FetchObject\User;
use Reformo\Domain\User\Persistence\Doctrine\Query\GetAllUsers;
use Reformo\Domain\User\Persistence\Doctrine\Query\GetUserByEmail;
use Reformo\Domain\User\Persistence\Doctrine\Query\GetUserById;

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

    public function getAllUsersPaginated(int $offset, int $limit) : UsersCollection
    {
        return GetAllUsers::execute($this->connection, ['offset' => $offset, 'limit' => $limit]);
    }
}
