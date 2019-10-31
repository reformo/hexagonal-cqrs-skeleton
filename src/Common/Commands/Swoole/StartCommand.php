<?php

declare(strict_types=1);

namespace Reformo\Common\Commands\Swoole;

use Psr\Container\ContainerInterface;
use Swoole\Http\Server as SwooleHttpServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;
use Zend\Expressive\Swoole\Command\IsRunningTrait;
use Zend\Expressive\Swoole\PidManager;
use function file_exists;
use function sys_get_temp_dir;
use function var_dump;

class StartCommand extends Command
{
    use IsRunningTrait;

    public const DEFAULT_NUM_WORKERS = 4;

    public const HELP = <<< 'EOH'
Start the web server. If --daemonize is provided, starts the server as a
background process and returns handling to the shell; otherwise, the
server runs in the current process.

Use --num-workers to control how many worker processes to start. If you
do not provide the option, 4 workers will be started.
EOH;

    private const PROGRAMMATIC_CONFIG_FILES = [
        'pipeline.php',
        'routes.php',
    ];

    /** @var ContainerInterface */
    private $container;
    /** @var PidManager */
    private $pidManager;

    public function __construct(ContainerInterface $container, string $name = 'start')
    {
        $this->container = $container;
        parent::__construct($name);
    }

    protected function configure() : void
    {
        $this->setDescription('Start the web server.');
        $this->setHelp(self::HELP);

        $this->addOption(
            'daemonize',
            'd',
            InputOption::VALUE_NONE,
            'Daemonize the web server (run as a background process).'
        );
        $this->addOption(
            'num-workers',
            'w',
            InputOption::VALUE_REQUIRED,
            'Number of worker processes to use.',
            4
        );
        $this->addOption(
            'module',
            null,
            InputOption::VALUE_REQUIRED,
            'Module for the programatic config files.'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $config           = $this->container->get('config');
        $this->pidManager = new PidManager($config['zend-expressive-swoole']['swoole-http-server']['options']['pid_file']
            ?? sys_get_temp_dir() . '/zend-swoole.pid');
        if ($this->isRunning()) {
            $output->writeln('<error>Server is already running!</error>');

            return 1;
        }
        $daemonize  = $input->getOption('daemonize');
        $numWorkers = $input->getOption('num-workers');
        $module     = $input->getOption('module');
        var_dump($numWorkers);
        $serverOptions = [];
        if ($daemonize) {
            $serverOptions['daemonize'] = $daemonize;
        }
        if ($numWorkers !== null) {
            $serverOptions['worker_num'] = $numWorkers;
        }

        if ($serverOptions !== []) {
            $server = $this->container->get(SwooleHttpServer::class);
            $server->set($serverOptions);
        }

        /** @var Application $app */
        $app = $this->container->get(Application::class);

        /** @var MiddlewareFactory $factory */
        $factory = $this->container->get(MiddlewareFactory::class);

        // Execute programmatic/declarative middleware pipeline and routing
        // configuration statements, if they exist
        foreach (self::PROGRAMMATIC_CONFIG_FILES as $configFile) {
            $configFile = 'modules/' . $module . '/config/' . $configFile;
            if (! file_exists($configFile)) {
                continue;
            }

            (require $configFile)($app, $factory, $this->container);
        }

        // Run the application
        $app->run();

        return 0;
    }
}
