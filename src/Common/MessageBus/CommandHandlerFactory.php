<?php

declare(strict_types=1);

namespace Reformo\Common\MessageBus;

use Interop\Container\ContainerInterface;
use ReflectionClass;
use Selami\Stdlib\Resolver;
use Zend\ServiceManager\Factory\FactoryInterface;

class CommandHandlerFactory implements FactoryInterface
{
    private $container;

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $this->container             = $container;
        $handlerConstructorArguments = Resolver::getParameterHints($requestedName, '__construct');
        $arguments                   = [];
        foreach ($handlerConstructorArguments as $argumentName => $argumentType) {
            $arguments[] = $this->getArgument($argumentName, $argumentType);
        }
        $handlerClass = new ReflectionClass($requestedName);

        return $handlerClass->newInstanceArgs($arguments);
    }

    private function getArgument(string $argumentName, string $argumentType)
    {
        return $this->container->has($argumentType) ? $this->container->get($argumentType) :
            $this->container->get($argumentName);
    }
}
