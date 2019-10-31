<?php
/**
 * @see       https://github.com/zendframework/zend-expressive-swoole for the canonical source repository
 */

declare(strict_types=1);

namespace Reformo\Common\Commands\Swoole;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Swoole\PidManager;

class StatusCommandFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new StatusCommand($container->get(PidManager::class));
    }
}
