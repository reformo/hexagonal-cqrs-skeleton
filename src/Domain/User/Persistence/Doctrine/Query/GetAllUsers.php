<?php
declare(strict_types=1);

namespace Reformo\Domain\User\Persistence\Doctrine\Query;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Reformo\Common\Exception\ExecutionFailed;
use Reformo\Common\Exception\InvalidParameter;
use Reformo\Common\Query;
use Reformo\Domain\User\Persistence\Doctrine\FetchObject\User as UserFetchObject;
use Reformo\Domain\User\Model\User;
use Reformo\Domain\User\Persistence\Doctrine\FetchObject\Users;

final class GetAllUsers
{
    use Query;
    private static $sql = <<<SQL
        SELECT *
          FROM users
         ORDER BY created_at DESC
         LIMIT :offset, :limit
SQL;

    public static function execute(Connection $connection, array $parameters) : ? Users
    {
        if (!array_key_exists('offset', $parameters)) {
            throw InvalidParameter::create('Query needs parameter named: offset');
        }
        if (!array_key_exists('limit', $parameters)) {
            throw InvalidParameter::create('Query needs parameter named: limit');
        }
        $query = new static($connection);
        $statement = $query->executeQuery(self::$sql, $parameters);
        try {
            $users = new Users();
            $records = $statement->fetchAll(FetchMode::CUSTOM_OBJECT, UserFetchObject::class);
            foreach ($records as $item) {
                $user = User::create($item->id, $item->email, $item->firstName, $item->lastName, $item->createdAt);
                $users->push($user);
            }
            return $users;
        } catch (\Throwable $exception) {
            throw ExecutionFailed::create($exception->getMessage());
        }
    }
}