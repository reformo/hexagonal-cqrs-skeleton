<?php
declare(strict_types=1);

use Reformo\Common\Factory\CommandHandlerFactory;
use Reformo\Domain\User\Query\GetAllUsersHandler;
use Reformo\Domain\User\Query\GetUserByIdHandler;

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
            GetUserByIdHandler::class => CommandHandlerFactory::class,
            GetAllUsersHandler::class => CommandHandlerFactory::class,
        ],
    ],
];
