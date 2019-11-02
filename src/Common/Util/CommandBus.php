<?php

declare(strict_types=1);

namespace Reformo\Common\Util;

use Reformo\Common\Interfaces\CommandBus as CommandBusInterface;

class CommandBus extends MessageBus implements CommandBusInterface
{
}
