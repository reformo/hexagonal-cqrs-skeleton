<?php

declare(strict_types=1);

namespace Reformo\Common\Interfaces;

interface QueryBus
{
    /**
     * Executes the given command and optionally returns a value
     *
     * @return mixed
     *
     * @var object
     */
    public function handle(object $query);
}