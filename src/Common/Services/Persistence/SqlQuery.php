<?php

declare(strict_types=1);

namespace Reformo\Common\Services\Persistence;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Statement;
use PDO;
use function gettype;

trait SqlQuery
{
    /** @var $connection Connection */
    private $connection;
    /** @var array */
    private $parameters;

    private function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    private static $types = [
        'integer' => PDO::PARAM_INT,
        'double' =>  PDO::PARAM_STR,
        'boolean' => PDO::PARAM_BOOL,
        'string' => PDO::PARAM_STR,
        'null' => PDO::PARAM_NULL,
    ];

    protected function executeQuery(string $sql, array $parameters) : Statement
    {
        $statement = $this->connection
            ->prepare($sql);
        foreach ($parameters as $key => $value) {
            $statement->bindValue($key, $value, self::$types[gettype($value)] ?? PDO::PARAM_STR);
        }
        $statement->execute();

        return $statement;
    }
}
