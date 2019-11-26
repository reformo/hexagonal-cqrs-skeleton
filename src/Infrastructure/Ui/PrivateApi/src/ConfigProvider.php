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
            'module-name'  => 'PrivateApi',
        ];
    }

    public function registerRoutes(Application $app, MiddlewareFactory $factory) : void
    {
        $app->get('/users', Handler\Users\Users::class, 'users');
        $app->post('/users', Handler\Users\RegisterUser::class, 'users.add');
        $app->get('/users/{userId}', Handler\Users\UserDetails::class, 'users.details');
        $app->patch('/users/{userId}', Handler\Users\UpdateUserInfo::class, 'users.patch');
        $app->put('/users/{userId}', Handler\Users\ReplaceUser::class, 'users.replace');
        $app->delete('/users/{userId}', Handler\Users\UnregisterUser::class, 'users.delete');
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'invokables' => [],
            'factories'  => [
                Handler\Users\Users::class => RequestHandlerFactory::class,
                Handler\Users\UserDetails::class => RequestHandlerFactory::class,
                Handler\Users\RegisterUser::class => RequestHandlerFactory::class,
                Handler\Users\UnregisterUser::class => RequestHandlerFactory::class,
                Handler\Users\UpdateUserInfo::class => RequestHandlerFactory::class,
                Handler\Users\ReplaceUser::class => RequestHandlerFactory::class,
            ],
        ];
    }
}
