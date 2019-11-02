<?php

declare(strict_types=1);

namespace Reformo\Common\Interfaces;

interface CommandBus
{
    public function handle(object $command);
}
