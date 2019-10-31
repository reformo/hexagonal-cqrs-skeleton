<?php

declare(strict_types=1);

use League\Tactician\CommandBus;
use Reformo\Common\Factory\TacticianCommandBusFactory;

return [
    'dependencies' => [
        'aliases' => [],
        'invokables' => [],
        'factories'  => [
            CommandBus::class => TacticianCommandBusFactory::class
        ],
    ],
];
