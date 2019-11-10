<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Persistence\Doctrine;

use Doctrine\DBAL\Connection;
use Reformo\Common\Exception\ExecutionFailed;
use Reformo\Common\Interfaces\Email;
use Reformo\Domain\User\Exception\CantUnregisterUserDoesNotExists;
use Reformo\Domain\User\Exception\UserAlreadyExists;
use Reformo\Domain\User\Exception\UserNotFound;
use Reformo\Domain\User\Interfaces\UserId;
use Reformo\Domain\User\Interfaces\UserRepository as UserRepositoryInterface;
use Reformo\Domain\User\Model\User;
use Reformo\Domain\User\Persistence\Doctrine\Query\AddUser;
use Reformo\Domain\User\Persistence\Doctrine\Query\GetUserByEmail;
use Reformo\Domain\User\Persistence\Doctrine\Query\GetUserById;
use Throwable;
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

    public function registerUser(User $user) : void
    {
        try {
            $this->getUserByEmail($user->email());
            throw UserAlreadyExists::create(
                sprintf('User already exists with the email provided: %s', $user->email()->toString()),
                ['provided_email' => $user->email()->toString()]
            );
        } catch (UserNotFound $exception) {
            AddUser::execute($this->connection, $user);
        }
    }

    /**
     * @inheritDoc
     */
    public function unregisterUser(UserId $userId) : void
    {
        try {
            $this->getUserById($userId);
        } catch (Throwable $exception) {
            throw CantUnregisterUserDoesNotExists::create($exception->getMessage());
        }
        try {
            $this->connection->delete(
                self::TABLE_NAME,
                ['id' => $userId->id()->toString()]
            );
        } catch (Throwable $exception) {
            throw ExecutionFailed::create($exception->getMessage());
        }
    }

    public function updateUserInfo(UserId $userId, array $payload) : void
    {
        $this->getUserById($userId);
        $this->connection->update(self::TABLE_NAME, $payload, ['id' => $userId->toString()]);
    }
}
