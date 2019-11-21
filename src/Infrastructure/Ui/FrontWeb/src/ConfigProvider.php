<?php

declare(strict_types=1);

namespace Reformo\FrontWeb;

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
            'templates'    => $this->getTemplates(),
            'module-name'  => 'FrontWeb',
        ];
    }

    public function registerRoutes(Application $app, MiddlewareFactory $factory) : void
    {
        $app->get('/', Handler\HomePageHandler::class, 'home');
        $app->post('/users/add', Handler\AddUserHandler::class, 'users.add');
        $app->get('/users/delete/{userId}', Handler\DeleteUserHandler::class, 'users.delete');
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'invokables' => [],
            'factories'  => [
                Handler\HomePageHandler::class => RequestHandlerFactory::class,
                Handler\AddUserHandler::class => RequestHandlerFactory::class,
                Handler\DeleteUserHandler::class => RequestHandlerFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'app'    => [__DIR__ . '/../templates/app'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/_layout'],
            ],
        ];
    }
}
