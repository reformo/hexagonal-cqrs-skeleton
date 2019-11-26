<?php
declare(strict_types=1);

use Reformo\Common\MessageBus\CommandHandlerFactory;
use Reformo\Domain\User\Command\RegisterUserHandler;
use Reformo\Domain\User\Command\UnregisterUserHandler;
use Reformo\Domain\User\Command\UpdateUserPartiallyHandler;

return [
    'dependencies' => [
        'aliases' => [
            // Fully\Qualified\ClassOrInterfaceName::class => Fully\Qualified\ClassName::class,
        ],
        'invokables' => [
            // Fully\Qualified\InterfaceName::class => Fully\Qualified\ClassName::class,
        ],
        'factories'  => [
        //    Command::class => CommandHandlerFactory::class
            RegisterUserHandler::class => CommandHandlerFactory::class,
            UnregisterUserHandler::class => CommandHandlerFactory::class,
            UpdateUserPartiallyHandler::class => CommandHandlerFactory::class,
        ],
    ],
];
