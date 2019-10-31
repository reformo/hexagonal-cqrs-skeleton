<?php
declare(strict_types=1);

use Reformo\Common\Factory\CommandHandlerFactory;
use Reformo\Domain\User\Command\RegisterUserHandler;
use Reformo\Domain\User\Query\GetAllUsersHandler;

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
            GetAllUsersHandler::class => CommandHandlerFactory::class,
        ],
    ],
];
