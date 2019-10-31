<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Persistence\Doctrine\Query;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Reformo\Common\Exception\ExecutionFailed;
use Reformo\Common\Exception\InvalidParameter;
use Reformo\Common\Query;
use Reformo\Domain\User\Model\User;
use Reformo\Domain\User\Persistence\Doctrine\FetchObject\User as UserFetchObject;
use Throwable;
use function array_key_exists;

final class GetUserById
{
    use Query;

    private static $sql = <<<SQL
        SELECT *
          FROM users
         WHERE id=:userId
SQL;

    public static function execute(Connection $connection, array $parameters) : ?User
    {
        if (! array_key_exists('userId', $parameters)) {
            throw InvalidParameter::create('Query needs parameter named: userId');
        }
        $query     = new static($connection);
        $statement = $query->executeQuery(self::$sql, $parameters);
        try {
            $item = $statement->fetchOne(FetchMode::CUSTOM_OBJECT, UserFetchObject::class);
            if ($item === null) {
                return null;
            }

            return User::create($item->id, $item->email, $item->firstName, $item->lastName, $item->createdAt);
        } catch (Throwable $exception) {
            throw ExecutionFailed::create($exception->getMessage());
        }
    }
}
