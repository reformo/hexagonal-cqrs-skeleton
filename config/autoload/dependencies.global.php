<?php

declare(strict_types=1);

use Zend\ServiceManager\Proxy\LazyServiceFactory;
use League\Tactician\CommandBus;
use Doctrine\DBAL\Connection as DoctrineConnection;
use Reformo\Common\Factory\TacticianCommandBusFactory;
use Reformo\Common\Factory\DoctrineConnectionFactory;
use Reformo\Domain\User\Interfaces\UserRepository;
use Reformo\Common\Factory\DoctrineRepositoryFactory;
use Reformo\Common\Util\TwigExtension;
use Reformo\Common\Factory\TwigExtensionFactory;

return [
    'dependencies' => [
        'aliases' => [],
        'factories'  => [
            CommandBus::class => TacticianCommandBusFactory::class,
            DoctrineConnection::class => DoctrineConnectionFactory::class,
            UserRepository::class => DoctrineRepositoryFactory::class,
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
