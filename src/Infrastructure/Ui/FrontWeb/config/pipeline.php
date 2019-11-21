<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Reformo\Common\Middleware\BaseUrlMiddleware;
use Reformo\Common\Middleware\LocalizationMiddleware;
use Zend\Expressive\Application;
use Zend\Expressive\Csrf\CsrfMiddleware;
use Zend\Expressive\Handler\NotFoundHandler;
use Zend\Expressive\Helper\ServerUrlMiddleware;
use Zend\Expressive\Helper\UrlHelperMiddleware;
use Zend\Expressive\MiddlewareFactory;
use Zend\Expressive\Router\Middleware\DispatchMiddleware;
use Zend\Expressive\Router\Middleware\RouteMiddleware;
use Zend\Expressive\Session\SessionMiddleware;
use Zend\Stratigility\Middleware\ErrorHandler;

/**
 * @var Application $app
 * @var MiddlewareFactory $factory
 * @var ContainerInterface $container
 */
return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    // The error handler should be the first (most outer) middleware to catch
    // all Exceptions.

    $app->pipe(ErrorHandler::class);
    $app->pipe(ServerUrlMiddleware::class);
    $app->pipe(BaseUrlMiddleware::class);
    $app->pipe(
        static function (ServerRequestInterface $request, RequestHandlerInterface $handler) use ($container) : ResponseInterface {
            $config = $container->get('config');

            return $handler->handle($request->withAttribute('moduleName', $config['module-name']));
        }
    );
    $app->pipe(SessionMiddleware::class);
    $app->pipe(CsrfMiddleware::class);
    // Pipe more middleware here that you want to execute on every request:
    // - bootstrapping
    // - pre-conditions
    // - modifications to outgoing responses
    //
    // Piped Middleware may be either callables or service names. Middleware may
    // also be passed as an array; each item in the array must resolve to
    // middleware eventually (i.e., callable or service name).
    //
    // Middleware can be attached to specific paths, allowing you to mix and match
    // applications under a common domain.  The handlers in each middleware
    // attached this way will see a URI with the matched path segment removed.
    //
    // i.e., path of "/api/member/profile" only passes "/member/profile" to $apiMiddleware
    // - $app->pipe('/api', $apiMiddleware);
    // - $app->pipe('/docs', $apiDocMiddleware);
    // - $app->pipe('/files', $filesMiddleware);

    // Register the routing middleware in the middleware pipeline.
    // This middleware registers the Zend\Expressive\Router\RouteResult request attribute.
    $app->pipe(RouteMiddleware::class);

    // Seed the UrlHelper with the routing results:
    $app->pipe(UrlHelperMiddleware::class);
    // Add more middleware here that needs to introspect the routing results; this
    // might include:
    //
    // - route-based authentication
    // - route-based validation
    // - etc.
    $app->pipe(LocalizationMiddleware::class);
    // Register the dispatch middleware in the middleware pipeline
    $app->pipe(DispatchMiddleware::class);

    // At this point, if no Response is returned by any middleware, the
    // NotFoundHandler kicks in; alternately, you can provide other fallback
    // middleware to execute.
    $app->pipe(NotFoundHandler::class);
};
