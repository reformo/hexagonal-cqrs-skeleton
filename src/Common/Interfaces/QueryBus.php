<?php

declare(strict_types=1);

namespace Reformo\Common\Interfaces;

interface QueryBus
{
    public function handle(object $query);
}
