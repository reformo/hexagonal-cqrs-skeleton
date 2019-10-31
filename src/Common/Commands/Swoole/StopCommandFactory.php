<?php
/**
 * @see       https://github.com/zendframework/zend-expressive-swoole for the canonical source repository
 */

declare(strict_types=1);

namespace Reformo\Common\Commands\Swoole;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Swoole\PidManager;

class StopCommandFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new StopCommand($container->get(PidManager::class));
    }
}
