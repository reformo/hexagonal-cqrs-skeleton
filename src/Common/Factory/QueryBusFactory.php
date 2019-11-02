<?php

declare(strict_types=1);

namespace Reformo\Common\Factory;

use Interop\Container\ContainerInterface;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\Mapping\MapByNamingConvention;
use League\Tactician\Handler\Mapping\MethodName\Invoke;
use Reformo\Common\Interfaces\QueryBus as QueryBusInterface;
use Reformo\Common\Util\CommandClassNameInflector;
use Reformo\Common\Util\QueryBus;
use Zend\ServiceManager\Factory\FactoryInterface;

class QueryBusFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null) : QueryBusInterface
    {
        $handlerMiddleware = new CommandHandlerMiddleware(
            $container,
            new MapByNamingConvention(
                new CommandClassNameInflector(),
                new Invoke()
            )
        );
        $commandBus        = new CommandBus($handlerMiddleware);

        return new QueryBus($commandBus);
    }
}
