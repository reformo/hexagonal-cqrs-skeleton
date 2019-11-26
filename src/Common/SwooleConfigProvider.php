<?php

declare(strict_types=1);

namespace Reformo\Common;

use Psr\Http\Message\ServerRequestInterface;
use Reformo\Common\Console\Swoole;
use Swoole\Http\Server as SwooleHttpServer;
use Zend\Expressive\Swoole\HotCodeReload\FileWatcher\InotifyFileWatcher;
use Zend\Expressive\Swoole\HotCodeReload\FileWatcherInterface;
use Zend\Expressive\Swoole\HotCodeReload\Reloader;
use Zend\Expressive\Swoole\HotCodeReload\ReloaderFactory;
use Zend\Expressive\Swoole\HttpServerFactory;
use Zend\Expressive\Swoole\Log;
use Zend\Expressive\Swoole\PidManager;
use Zend\Expressive\Swoole\PidManagerFactory;
use Zend\Expressive\Swoole\ServerRequestSwooleFactory;
use Zend\Expressive\Swoole\StaticResourceHandler;
use Zend\Expressive\Swoole\StaticResourceHandlerFactory;
use Zend\Expressive\Swoole\StaticResourceHandlerInterface;
use Zend\Expressive\Swoole\SwooleRequestHandlerRunner;
use Zend\Expressive\Swoole\SwooleRequestHandlerRunnerFactory;
use Zend\Expressive\Swoole\WhoopsPrettyPageHandlerDelegator;
use Zend\HttpHandlerRunner\RequestHandlerRunner;
use const PHP_SAPI;
use function extension_loaded;

class SwooleConfigProvider
{
    public function __invoke() : array
    {
        $config = PHP_SAPI === 'cli' && extension_loaded('swoole')
            ? ['dependencies' => $this->getDependencies()]
            : [];

        $config['zend-expressive-swoole'] = $this->getDefaultConfig();

        return PHP_SAPI === 'cli' && extension_loaded('swoole') ? $config : [];
    }

    public function getDefaultConfig() : array
    {
        return [
            'swoole-http-server' => [
                // A prefix for the process name of the master process and workers.
                // By default the master process will be named `expressive-master`,
                // each http worker `expressive-worker-n` and each task worker
                // `expressive-task-worker-n` where n is the id of the worker
                'process-name' => 'expressive',
                'options' => [
                    // We set a default for this. Without one, Swoole\Http\Server
                    // defaults to the value of `ulimit -n`. Unfortunately, in
                    // virtualized or containerized environments, this often
                    // reports higher than the host container allows. 1024 is a
                    // sane default; users should check their host system, however,
                    // and set a production value to match.
                    'max_conn' => 1024,
                ],
                'static-files' => ['enable' => false],
            ],
        ];
    }

    public function getDependencies() : array
    {
        return [
            'factories'  => [
                Swoole\ReloadCommand::class           => Swoole\ReloadCommandFactory::class,
                Swoole\StartCommand::class            => Swoole\StartCommandFactory::class,
                Swoole\StatusCommand::class           => Swoole\StatusCommandFactory::class,
                Swoole\StopCommand::class             => Swoole\StopCommandFactory::class,
                Log\AccessLogInterface::class          => Log\AccessLogFactory::class,
                Log\SwooleLoggerFactory::SWOOLE_LOGGER => Log\SwooleLoggerFactory::class,
                PidManager::class                      => PidManagerFactory::class,
                SwooleRequestHandlerRunner::class      => SwooleRequestHandlerRunnerFactory::class,
                ServerRequestInterface::class          => ServerRequestSwooleFactory::class,
                StaticResourceHandler::class           => StaticResourceHandlerFactory::class,
                SwooleHttpServer::class                => HttpServerFactory::class,
                Reloader::class                        => ReloaderFactory::class,
            ],
            'aliases' => [
                RequestHandlerRunner::class           => SwooleRequestHandlerRunner::class,
                StaticResourceHandlerInterface::class => StaticResourceHandler::class,
                FileWatcherInterface::class           => InotifyFileWatcher::class,
            ],
            'delegators' => [
                'Zend\Expressive\WhoopsPageHandler' => [
                    WhoopsPrettyPageHandlerDelegator::class,
                ],
            ],
        ];
    }
}
