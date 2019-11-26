<?php
/**
 * @see       https://github.com/zendframework/zend-expressive-swoole for the canonical source repository
 */

declare(strict_types=1);

namespace Reformo\Common\Console\Swoole;

use Psr\Container\ContainerInterface;

class StartCommandFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new StartCommand($container);
    }
}
