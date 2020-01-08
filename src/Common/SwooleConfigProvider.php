<?php

declare(strict_types=1);

namespace Reformo\Common;

use Psr\Http\Message\ServerRequestInterface;
use Reformo\Common\Console\Swoole;
use Swoole\Http\Server as SwooleHttpServer;
use Mezzio\Swoole\HotCodeReload\FileWatcher\InotifyFileWatcher;
use Mezzio\Swoole\HotCodeReload\FileWatcherInterface;
use Mezzio\Swoole\HotCodeReload\Reloader;
use Mezzio\Swoole\HotCodeReload\ReloaderFactory;
use Mezzio\Swoole\HttpServerFactory;
use Mezzio\Swoole\Log;
use Mezzio\Swoole\PidManager;
use Mezzio\Swoole\PidManagerFactory;
use Mezzio\Swoole\ServerRequestSwooleFactory;
use Mezzio\Swoole\StaticResourceHandler;
use Mezzio\Swoole\StaticResourceHandlerFactory;
use Mezzio\Swoole\StaticResourceHandlerInterface;
use Mezzio\Swoole\SwooleRequestHandlerRunner;
use Mezzio\Swoole\SwooleRequestHandlerRunnerFactory;
use Mezzio\Swoole\WhoopsPrettyPageHandlerDelegator;
use Laminas\HttpHandlerRunner\RequestHandlerRunner;
use const PHP_SAPI;
use function extension_loaded;

class SwooleConfigProvider
{
    public function __invoke() : array
    {
        $config = PHP_SAPI === 'cli' && extension_loaded('swoole')
            ? ['dependencies' => $this->getDependencies()]
            : [];

        $config['mezzio-swoole'] = $this->getDefaultConfig();

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
                'Mezzio\WhoopsPageHandler' => [
                    WhoopsPrettyPageHandlerDelegator::class,
                ],
            ],
        ];
    }
}
