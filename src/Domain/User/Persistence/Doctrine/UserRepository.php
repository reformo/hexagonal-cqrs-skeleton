<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Persistence\Doctrine;

use Doctrine\DBAL\Connection;
use Reformo\Common\Interfaces\Email;
use Reformo\Domain\User\Exception\UserAlreadyExists;
use Reformo\Domain\User\Exception\UserNotFound;
use Reformo\Domain\User\Interfaces\UserId;
use Reformo\Domain\User\Interfaces\UserRepository as UserRepositoryInterface;
use Reformo\Domain\User\Model\User;
use Reformo\Domain\User\Model\UsersCollection;
use Reformo\Domain\User\Persistence\Doctrine\Query\AddUser;
use Reformo\Domain\User\Persistence\Doctrine\Query\GetAllUsers;
use Reformo\Domain\User\Persistence\Doctrine\Query\GetUserByEmail;
use Reformo\Domain\User\Persistence\Doctrine\Query\GetUserById;
use function sprintf;

class UserRepository implements UserRepositoryInterface
{
    private const TABLE_NAME = 'users';
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getUserById(UserId $userId) : ?User
    {
        $user = GetUserById::execute($this->connection, ['userId' => $userId->toString()]);

        return User::create($user->id(), $user->email(), $user->firstName(), $user->lastName(), $user->createdAt());
    }

    public function getUserByEmail(Email $email) : ?User
    {
        $user =  GetUserByEmail::execute($this->connection, ['email' => $email->toString()]);

        return User::create($user->id(), $user->email(), $user->firstName(), $user->lastName(), $user->createdAt());
    }

    public function add(User $user) : bool
    {
        try {
            $this->getUserByEmail($user->email());
            throw UserAlreadyExists::create(
                sprintf('User already exists with the email provided: %s', $user->email()->toString()),
                ['provided_email' => $user->email()->toString()]
            );
        } catch (UserNotFound $exception) {
            return AddUser::execute($this->connection, $user) > 0;
        }
    }

    public function getAllUsersPaginated(int $offset, int $limit) : UsersCollection
    {
        $users   = new UsersCollection();
        $records = GetAllUsers::execute($this->connection, ['offset' => $offset, 'limit' => $limit]);
        foreach ($records as $item) {
            $user =User::create($item->id(), $item->email(), $item->firstName(), $item->lastName(), $item->createdAt());
            $users->push($user);
        }

        return $users;
    }
}
