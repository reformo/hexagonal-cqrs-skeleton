<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Reformo\PrivateApi\ConfigProvider as PrivateApiConfigProvider;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;

/**
 * @var Application $app
 * @var MiddlewareFactory $factory
 * @var ContainerInterface $container
 */
return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    (new PrivateApiConfigProvider())->registerRoutes($app, $factory);
};
