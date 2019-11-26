<?php

declare(strict_types=1);

use Zend\ServiceManager\Proxy\LazyServiceFactory;
use Doctrine\DBAL\Connection as DoctrineConnection;
use League\Tactician\CommandBus as TacticianCommandBus;
use Reformo\Common\Services\MessageBus\TacticianCommandBusFactory;
use Reformo\Common\Services\MessageBus\CommandBusFactory;
use Reformo\Common\Services\MessageBus\QueryBusFactory;
use Reformo\Common\Services\MessageBus\Interfaces\CommandBus;
use Reformo\Common\Services\MessageBus\Interfaces\QueryBus;
use Reformo\Common\Factory\DoctrineConnectionFactory;
use Reformo\Common\Factory\DoctrineRepositoryFactory;
use Reformo\Common\Util\TwigExtension;
use Reformo\Common\Factory\TwigExtensionFactory;
use Reformo\Domain\User\Interfaces\UserRepository;
use Reformo\Domain\User\Interfaces\UserQuery;

return [
    'dependencies' => [
        'aliases' => [],
        'factories'  => [
            TacticianCommandBus::class => TacticianCommandBusFactory::class,
            CommandBus::class => CommandBusFactory::class,
            QueryBus::class => QueryBusFactory::class,
            DoctrineConnection::class => DoctrineConnectionFactory::class,
            UserRepository::class => DoctrineRepositoryFactory::class,
            UserQuery::class => DoctrineRepositoryFactory::class,
            TwigExtension::class => TwigExtensionFactory::class
        ],
        'lazy_services' => [
            // Mapping services to their class names is required
            // since the ServiceManager is not a declarative DIC.
            'class_map' => [
                DoctrineConnection::class => DoctrineConnection::class,
            ],
        ],
        'delegators' => [
            DoctrineConnection::class => [
                LazyServiceFactory::class,
            ],
        ],
    ],
];
