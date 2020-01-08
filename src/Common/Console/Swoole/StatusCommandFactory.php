<?php
/**
 * @see       https://github.com/mezzio/mezzio-swoole for the canonical source repository
 */

declare(strict_types=1);

namespace Reformo\Common\Console\Swoole;

use Psr\Container\ContainerInterface;
use Mezzio\Swoole\PidManager;

class StatusCommandFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new StatusCommand($container->get(PidManager::class));
    }
}
