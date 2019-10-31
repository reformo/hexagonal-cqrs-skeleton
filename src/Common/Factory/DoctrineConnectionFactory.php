<?php

declare(strict_types=1);

namespace Reformo\Common\Factory;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Schema\Table;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class DoctrineConnectionFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null) : Connection
    {
        $config           = $container->get('config');
        $connectionParams = $config['doctrine'];
        $doctrineConfig   = new Configuration();
        $connection       = DriverManager::getConnection($connectionParams, $doctrineConfig);
        // +++++++ YOU SHOULD REMOVE THIS PART IN YOUR APP +++++++
        $schema = $connection->getSchemaManager();
        if (! $schema->tablesExist('users')) {
            $users = new Table('users');
            $users->addColumn('id', 'guid');
            $users->setPrimaryKey(['id']);
            $users->addColumn('first_name', 'string', ['length' => 64]);
            $users->addColumn('last_name', 'string', ['length' => 64]);
            $users->addColumn('email', 'string', ['length' => 160]);
            $users->addColumn('created_at', 'datetime');
            $users->addIndex(['email', 'created_at'], 'users_idx');
            $users->addUniqueIndex(['email'], 'users_unq');
            $schema->createTable($users);
        }

        // -------- YOU SHOULD REMOVE THIS PART IN YOUR APP --------
        return $connection;
    }
}
