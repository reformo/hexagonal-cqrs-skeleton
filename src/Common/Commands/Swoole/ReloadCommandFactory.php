<?php
/**
 * @see       https://github.com/zendframework/zend-expressive-swoole for the canonical source repository
 */

declare(strict_types=1);

namespace Reformo\Common\Commands\Swoole;

use Psr\Container\ContainerInterface;
use const SWOOLE_BASE;

class ReloadCommandFactory
{
    public function __invoke(ContainerInterface $container) : ReloadCommand
    {
        $config = $container->has('config') ? $container->get('config') : [];
        $mode   = $config['zend-expressive-swoole']['swoole-http-server']['mode'] ?? SWOOLE_BASE;

        return new ReloadCommand($mode);
    }
}
