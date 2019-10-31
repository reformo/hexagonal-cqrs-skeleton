<?php

declare(strict_types=1);

use League\Tactician\CommandBus;
use Doctrine\DBAL\Connection as DoctrineConnection;
use Reformo\Common\Factory\TacticianCommandBusFactory;
use Reformo\Common\Factory\DoctrineConnectionFactory;
use Reformo\Domain\User\Interfaces\UserRepository;
use Reformo\Common\Factory\DoctrineRepositoryFactory;

return [
    'dependencies' => [
        'aliases' => [],
        'invokables' => [],
        'factories'  => [
            CommandBus::class => TacticianCommandBusFactory::class,
            DoctrineConnection::class => DoctrineConnectionFactory::class,
            UserRepository::class => DoctrineRepositoryFactory::class
        ],
    ],
];
