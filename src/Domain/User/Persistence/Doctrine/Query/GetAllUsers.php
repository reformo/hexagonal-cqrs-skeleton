<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Persistence\Doctrine\Query;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Reformo\Common\Exception\ExecutionFailed;
use Reformo\Common\Exception\InvalidArgument;
use Reformo\Common\Query;
use Reformo\Domain\User\Model\UsersCollection;
use Reformo\Domain\User\Persistence\Doctrine\ResultObject\User;
use Throwable;
use function array_key_exists;

final class GetAllUsers
{
    use Query;

    private static $sql = <<<SQL
        SELECT *
          FROM users
         ORDER BY created_at DESC
         LIMIT :offset, :limit
SQL;

    public static function execute(Connection $connection, array $parameters) : ?UsersCollection
    {
        if (! array_key_exists('offset', $parameters)) {
            throw InvalidArgument::create('Query needs parameter named: offset');
        }
        if (! array_key_exists('limit', $parameters)) {
            throw InvalidArgument::create('Query needs parameter named: limit');
        }
        $query     = new static($connection);
        $statement = $query->executeQuery(self::$sql, $parameters);
        try {
            $records = $statement->fetchAll(FetchMode::CUSTOM_OBJECT, User::class);

            return new UsersCollection($records);
        } catch (Throwable $exception) {
            throw ExecutionFailed::create($exception->getMessage());
        }
    }
}
