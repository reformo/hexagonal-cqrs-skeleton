<?php

declare(strict_types=1);

namespace Reformo\PrivateApi;

use Reformo\Common\Factory\RequestHandlerFactory;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    public function registerRoutes(Application $app, MiddlewareFactory $factory) : void
    {
        $app->get('/', Handler\PingHandler::class, 'root');
        $app->get('/error', Handler\PingErrorHandler::class, 'error');
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'invokables' => [],
            'factories'  => [
                Handler\PingHandler::class => RequestHandlerFactory::class,
                Handler\PingErrorHandler::class => RequestHandlerFactory::class,
            ],
        ];
    }
}
