<?php

declare(strict_types=1);

namespace Reformo\Common\Services\MessageBus;

use Interop\Container\ContainerInterface;
use League\Tactician\CommandBus as TacticianCommandBus;
use Reformo\Common\Services\MessageBus\Interfaces\CommandBus as CommandBusInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class CommandBusFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null) : CommandBusInterface
    {
        $commandBus = $container->get(TacticianCommandBus::class);

        return new CommandBus($commandBus);
    }
}
