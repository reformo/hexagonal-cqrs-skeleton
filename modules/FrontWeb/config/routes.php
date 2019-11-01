<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;
use Reformo\FrontWeb\ConfigProvider as FrontWebConfigProvider;

/**
 * @var Application $app
 * @var MiddlewareFactory $factory
 * @var ContainerInterface $container
 */
return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    (new FrontWebConfigProvider())->registerRoutes($app, $factory);
};
