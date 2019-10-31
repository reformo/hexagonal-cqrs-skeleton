<?php
declare(strict_types=1);

namespace Reformo\Common\Factory;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Schema\Table;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class DoctrineRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $connection = $container->get(Connection::class);
        $repositoryClassName = str_replace('Interfaces', 'Persistence\\Doctrine', $requestedName);
        return new $repositoryClassName($connection);
    }
}