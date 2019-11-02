<?php

declare(strict_types=1);

namespace Reformo\Common\Factory;

use Interop\Container\ContainerInterface;
use Reformo\Common\Util\TwigExtension;
use Zend\ServiceManager\Factory\FactoryInterface;

class TwigExtensionFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new TwigExtension();
    }
}
