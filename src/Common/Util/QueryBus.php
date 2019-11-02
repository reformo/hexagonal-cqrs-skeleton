<?php

declare(strict_types=1);

namespace Reformo\Common\Util;

use Reformo\Common\Interfaces\QueryBus as QueryBusInterface;
use \Reformo\Common\Util\MessageBus;

class QueryBus extends MessageBus implements QueryBusInterface
{
}
