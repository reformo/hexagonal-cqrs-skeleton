<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Reformo\FrontWeb\ConfigProvider as FrontWebConfigProvider;
use Mezzio\Application;
use Mezzio\MiddlewareFactory;

/**
 * @var Application $app
 * @var MiddlewareFactory $factory
 * @var ContainerInterface $container
 */
return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    (new FrontWebConfigProvider())->registerRoutes($app, $factory);
};
