<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Persistence\Doctrine\Query;

use Doctrine\DBAL\Connection;
use Reformo\Common\Exception\InvalidArgument;
use Reformo\Common\Query;
use Reformo\Domain\User\Model\User;
use Reformo\Domain\User\Persistence\Doctrine\UserMapper;

final class AddUser
{
    use Query;

    public static function execute(Connection $connection, User $user) : int
    {
        if (! $user instanceof User) {
            throw InvalidArgument::create('Provided data is not a User object!');
        }
        $mapper = new UserMapper($user);

        return $connection->insert('users', $mapper->toDatabasePayload());
    }
}
