<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Persistence\Doctrine\Query;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Reformo\Common\Exception\ExecutionFailed;
use Reformo\Common\Exception\InvalidArgument;
use Reformo\Common\Query;
use Reformo\Domain\User\Exception\UserNotFound;
use Reformo\Domain\User\Persistence\FetchObject\User;
use Throwable;
use function array_key_exists;
use function count;
use function sprintf;

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
            throw InvalidArgument::create('Query needs parameter named: userId');
        }
        $query     = new static($connection);
        $statement = $query->executeQuery(self::$sql, $parameters);
        try {
            $records = $statement->fetchAll(FetchMode::CUSTOM_OBJECT, User::class);
            if (count($records) === 0) {
                throw UserNotFound::create(sprintf('User not found by id: %s', $parameters['id']));
            }

            return $records[0];
        } catch (Throwable $exception) {
            throw ExecutionFailed::create($exception->getMessage());
        }
    }
}
